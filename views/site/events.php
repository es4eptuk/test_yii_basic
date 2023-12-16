<?php

use app\models\Event;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var \app\models\event\SearchEvent $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'date',
            'description:ntext',
            [
                'label' => 'Organizers',
                'value' => function ($model) {
                    $result = [];
                    foreach ($model->organizers as $organizer) {
                        $result[] = $organizer->full_name;
                    }
                    return implode(', ', $result);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
