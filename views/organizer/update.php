<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\organizer\UpdateOrganizer $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Update Organizer: ' . $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Organizers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->_model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organizer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="organizer-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <?= $form
            ->field($model, 'events')
            ->dropDownList($model->listEvents, ['multiple' => true, 'selected' => true])
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
