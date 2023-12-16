<?php

use app\models\Organizer;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var \app\models\event\SearchOrganizer $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Organizers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organizer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Organizer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'full_name',
            'email:email',
            'phone',
            [
                'label' => 'Events',
                'value' => function ($model) {
                    $result = [];
                    foreach ($model->events as $event) {
                        $result[] = $event->name.' ('.$event->date.')';
                    }
                    return implode(', ', $result);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Organizer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
