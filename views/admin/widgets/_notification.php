<?php
if (Yii::$app->session->hasFlash('message')):
    $message = Yii::$app->session->getFlash('message');
    if (is_array($message) && count($message) == 2) {

        if($message[0] == 'error')
            $message[0] = 'danger';

        $body = $message[1];
        switch($message[0]){
            case 'success':
                $body = '<span class="fa fa-alert fa-2x fa-check-circle-o"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            case 'danger':
                $body = '<span class="fa fa-alert fa-exclamation-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            case 'warning':
                $body = '<span class="fa fa-alert fa-question-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            case 'info':
                $body = '<span class="fa fa-alert fa-info-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            default:
                $body = '<span class="fa fa-alert fa-info-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;
        }

        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-' . $message[0],
                'style' => 'border-radius:0; margin:10px 0; padding:10px 30px; clear:both;'
            ],
            'body' => $body,
        ]);
    } elseif (is_string($message)) {
        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => '<span class="fa fa-alert fa-info-circle"></span> <span>' . $message . '</span>',
        ]);
    }
endif;
?>