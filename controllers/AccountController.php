<?php

namespace app\controllers;

use Yii;
use app\models\Account;
use app\models\AccountSearchModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\lib\Chart;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
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
                        'roles' => ['user']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
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
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $currencies = CurrencyController::currenciesList();
        $id_user = Yii::$app->user->id;

        return $this->render('create', [
            'model' => $model,
            'id_user' => $id_user,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $currencies = CurrencyController::currenciesList();
        $id_user = Yii::$app->user->id;

        return $this->render('update', [
            'model' => $model,
            'id_user' => $id_user,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionChart()
    {
        $data = Account::find()->where('id_user='.Yii::$app->user->id)->all();
        $accounts = ArrayHelper::map($data, 'id', 'title');

        $operationsByAccount = [];
        foreach($accounts as $id_account=>$title){
            $operations = OperationController::findOperationsOfAccount($id_account);
            $operationsByAccount[$title] = $this->splitValueByMonths($operations);
        }

        $chart = new Chart($operationsByAccount);
        $data = $chart->data;

        return $this->render('chart', [
            'data' => $data,
        ]);
    }
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    static public function accountsListOfUser()
    {
        $data = Account::find()->where('id_user='.Yii::$app->user->id)->all();
        $accounts = ArrayHelper::map($data, 'id', 'title');
        asort($accounts);
        return $accounts;
    }

    /**
     * Takes an array of operations and splits them by months
     * @param array $operations
     * @return array value by months
     *
     */
    public function splitValueByMonths($operations)
    {
        $months = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];

        foreach($operations as $oper){
            $m = explode('-', $oper['operation_date'])[1];

            switch($m){
                case '01': $months['January'] += $oper['value']; break;
                case '02': $months['February'] += $oper['value']; break;
                case '03': $months['March'] += $oper['value']; break;
                case '04': $months['April'] += $oper['value']; break;
                case '05': $months['May'] += $oper['value']; break;
                case '06': $months['June'] += $oper['value']; break;
                case '07': $months['July'] += $oper['value']; break;
                case '08': $months['August'] += $oper['value']; break;
                case '09': $months['September'] += $oper['value']; break;
                case '10': $months['October'] += $oper['value']; break;
                case '11': $months['November'] += $oper['value']; break;
                case '12': $months['December'] += $oper['value']; break;
                default: break;
            }
        }

        return $months;
    }
}
