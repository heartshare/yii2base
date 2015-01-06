<?php
if (Yii::$app->session->hasFlash('message')):
    $message = Yii::$app->session->getFlash('message');
    if (is_array($message) && count($message) == 2) {

        $alertOptions = \yii\helpers\ArrayHelper::merge(
            [
                'class' => 'alert-base'
            ],
            isset($options) ? $options : []
        );

        if($message[0] == 'error')
            $message[0] = 'danger';

        $body = $message[1];
        switch($message[0]){
            case 'success':
                $body = '<span class="fa fa-alert fa-2x fa-check-circle-o"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            case 'danger':
                $body = '<span class="fa fa-alert fa-2x  fa-exclamation-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            case 'warning':
                $body = '<span class="fa fa-alert fa-2x  fa-question-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            case 'info':
                $body = '<span class="fa fa-alert fa-2x  fa-info-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;

            default:
                $body = '<span class="fa fa-alert fa-2x  fa-info-circle"></span> <span>' . \yii\helpers\Html::encode($message[1]) . '</span>';
                break;
        }

        $alertOptions['class'] .= ' alert-flash alert-' . $message[0];

        echo \yii\bootstrap\Alert::widget([
            'options' => $alertOptions,
            'body' => $body,
        ]);
    } elseif (is_string($message)) {
        $alertOptions = \yii\helpers\ArrayHelper::merge(
            [
                'class' => ' alert-info alert-flash',
            ],
            isset($options) ? $options : []
        );
        echo \yii\bootstrap\Alert::widget([
            'options' => $alertOptions,
            'body' => '<span class="fa fa-alert fa-info-circle"></span> <span>' . $message . '</span>',
        ]);
    }
endif;
?>