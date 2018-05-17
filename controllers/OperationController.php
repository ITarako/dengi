<?php

namespace app\controllers;

use Yii;
use app\models\Operation;
use app\models\OperationSearchModel;
use app\models\Category;
use app\models\Account;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;

/**
 * OperationController implements the CRUD actions for Operation model.
 */
class OperationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user', 'admin']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Operation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OperationSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Operation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Operation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Operation();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    $old_account_value = \Yii::$app->db->createCommand("SELECT value FROM accounts WHERE id={$model->id_account}")->queryOne()['value'];
                    $new_account_value = $old_account_value+$model->value;
                    \Yii::$app->db->createCommand("UPDATE accounts SET value=$new_account_value WHERE id={$model->id_account}")->execute();
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        $accounts = AccountController::accountsListOfUser();
        $categories = CategoryController::categoriesList();

        return $this->render('create', [
            'model' => $model,
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Operation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_value = $model->value;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    $old_account_value = \Yii::$app->db->createCommand("SELECT value FROM accounts WHERE id={$model->id_account}")->queryOne()['value'];
                    $new_account_value = $old_account_value-$old_value+$model->value;
                    \Yii::$app->db->createCommand("UPDATE accounts SET value=$new_account_value WHERE id={$model->id_account}")->execute();
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        $accounts = AccountController::accountsListOfUser();
        $categories = CategoryController::categoriesList();

        return $this->render('update', [
            'model' => $model,
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Operation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $old_account_value = \Yii::$app->db->createCommand("SELECT value FROM accounts WHERE id={$model->id_account}")->queryOne()['value'];
            $new_account_value = $old_account_value-$model->value;
            $model->delete();
            \Yii::$app->db->createCommand("UPDATE accounts SET value=$new_account_value WHERE id={$model->id_account}")->execute();
            $transaction->commit();
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->redirect(['index']);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->operationsFile = UploadedFile::getInstance($model, 'operationsFile');
            if ($model->upload()) {
                return $this->redirect(['upload/index']);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionParse($path)
    {
        [$data, $account_title] = $this->getDataFromOperationsFile($path);

        $account = Account::find()->where(['id_user'=>Yii::$app->user->id, 'title' => $account_title])->one();
        if(empty($account))
            throw new BadRequestHttpException("Account '$account_title' not found");

        $categories = Category::find()->all();
        $categories = ArrayHelper::Map($categories, 'slug', 'id');

        [$rows, $total_value] = $this->validateDataItems($data, $categories, $account->id);

        $cols = ['value', 'title', 'id_category', 'id_account', 'operation_date'];
        $account->value+=$total_value;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $account->save();
            Yii::$app->db->createCommand()->batchInsert(Operation::tableName(), $cols, $rows)->execute();
            $transaction->commit();

            return $this->redirect(['index']);

        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Finds the Operation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Operation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    static public function findOperationsOfAccount($id_account)
    {
        return Operation::find()->where("id_account=$id_account")->asArray()->all();
    }

    public function getDataFromOperationsFile(string $path) :array
    {
        try {
            $data = file_get_contents($path);
            $data = json_decode($data, true);
            $account_title = $data[0]['account_title'];

            if(empty($account_title))
                throw new ErrorException();

        } catch (ErrorException $e) {
            throw new BadRequestHttpException("$path not found or invalid");
        }

        return [$data, $account_title];
    }

    public function validateDataItems(array $data, array $categories, int $account_id) :array
    {
        $rows = [];
        $total_value = 0;

        foreach ($data as $item) {
            $item['id_category'] = $categories[$item['slug']];
            $item['id_account'] = $account_id;

            $model = new Operation();
            $model->attributes = $item;
            if($model->validate()){
                $total_value +=  $model->value;

                $rows[] = [
                    'value' => $model->value,
                    'title' => $model->title,
                    'id_category' => $model->id_category,
                    'id_account' => $model->id_account,
                    'operation_date' => $model->operation_date,
                ];
            } else {
                throw new BadRequestHttpException("$item is invalid");
            }
        }

        return [$rows, $total_value];
    }
}
