<?php
namespace common\components\Validator;

use Yii;
use yii\validators\Validator;

class VideoUrlValidator extends Validator
{
    /**
     * Save url matches to array
     * @var array
     */
    public $videoMatches =[];

    private $youtube = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
    private $vimeo = '/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/';

    /**
     * @param $url
     * @return int
     */
    public function youtubeValidation($url)
    {
        return preg_match($this->youtube, $url, $this->videoMatches);
    }

    /**
     * @param $url
     * @return int
     */
    public function vimeoValidation($url)
    {
        return preg_match($this->vimeo, $url, $this->videoMatches);
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->youtubeValidation($model->$attribute) && !$this->vimeoValidation($model->$attribute)) {
            $this->addError($model, $attribute, Yii::t('app', 'Enter a valid URL of vimeo or youtube video.'));
        }
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param \yii\web\View $view
     * @return string
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $youtubeVal = $this->youtube;
        $vimeoVal = $this->vimeo;
        $message = json_encode(Yii::t('app', 'Enter a valid URL of vimeo or youtube video.'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return <<<JS
        if(value !== '' && !$youtubeVal.test(value) && !$vimeoVal.test(value)){
            messages.push($message);
        }
JS;
    }
}
