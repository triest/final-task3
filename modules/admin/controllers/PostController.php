<?php

namespace app\modules\admin\controllers;


use Yii;
use app\models\Post;
use app\models\PostSearch;
use app\models\Tag;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetTags($id){
        $post=$this->findModel($id);
        $selectedTags=[];
        $selectedTags=$post->getSelectedTags();
        //   var_dump($selectedTags);
        $tags=ArrayHelper::map(Tag::find()->all(),'id','name');
        if(Yii::$app->request->isPost){
            //   echo 'ispost';
            $tags=Yii::$app->request->post('tags');
            //  var_dump($tags);
            $post->saveTags($tags);
            //  echo 'tags saved';
            //   die();
            return $this->actionView($id);
            //  return $this->render(['view','id'=>$post->id]);
        }
        return $this->render('tags',['post'=>$post,'tags'=>$tags,'selectedTags'=>$selectedTags]);
        //var_dump($post);
        //var_dump($tag->post);
    }
    public function actionSetStatus($id){
        //  var_dump($id);
        //  die();
        $post=$this->findModel($id);
        $selectedTags=[];
        $selectedTags=$post->getSelectedTags();
        //   var_dump($selectedTags);
        $tags=ArrayHelper::map(Tag::find()->all(),'id','name');
        if(Yii::$app->request->isPost){
            //   echo 'ispost';
            //var_dump(Yii::$app->request);
            // die();
            //  $tags=Yii::$app->request->post('tags');
            //    var_dump(Yii::$app->request->post());
            $status=Yii::$app->request->post("status");
            var_dump($status);
            //  var_dump($tags);
            $post->saveStatus($status);
            //    die();
            //  echo 'tags saved';
            //   die();
            return $this->actionView($id);
            //  return $this->render(['view','id'=>$post->id]);
        }
        $status=[];
        return $this->render('status',['post'=>$post]);
        //var_dump($post);
        //var_dump($tag->post);
    }
}
