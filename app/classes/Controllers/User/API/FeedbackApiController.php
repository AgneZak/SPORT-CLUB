<?php


namespace App\Controllers\User\API;


use App\App;
use App\Controllers\Base\API\AuthController;
use App\Views\Forms\Feedback\FeedbackCreateForm;
use Core\Api\Response;

class FeedbackApiController extends AuthController
{
    public function create(): string
    {
        // This is a helper class to make sure
        // we use the same API json response structure
        $response = new Response();
        $form = new FeedbackCreateForm();

        if ($form->validate()) {
            $user = App::$session->getUser();
            $feedback = $form->values();

            $feedback['id'] = App::$db->insertRow('feedback', $form->values() + [
                    'name' => $user['name'],
                    'timestamp' => time()
                ]);
            $feedback['name'] = $user['name'];

            $feedback['timestamp'] = $this->timeFormat(time());
            //TODO: feedback needs a build row
            $response->setData($feedback);
        } else {
            $response->setErrors($form->getErrors());
        }

        // Returns json-encoded response
        return $response->toJson();
    }


    /**
     * Returns formatted time from timestamp given in row.
     *
     * @param $time
     * @return string
     */
    private function timeFormat($time)
    {
        $timeStamp = date('Y-m-d H:i:s', $time);
        $difference = abs(strtotime("now") - strtotime($timeStamp));
        $days = floor($difference / (3600 * 24));
        $hours = floor($difference / 3600);
        $minutes = floor(($difference - ($hours * 3600)) / 60);
        $seconds = floor($difference % 60);

        if ($days) {
            $hours = $hours - 24;
            $result = "{$days}d {$hours}:{$minutes} H";
        } elseif ($minutes) {
            $result = "{$minutes} min";
        } elseif ($hours) {
            $result = "{$hours}:{$minutes} H";
        } else {
            $result = "{$seconds} seconds";
        }

        return $result;
    }
}