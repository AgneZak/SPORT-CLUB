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
            $users = App::$db->getRowsWhere('users');
            $logged_user = App::$session->getUser();

            foreach ($users as $id => $user) {
                if ($logged_user['email'] === $user['email']) {
                    $user_id = $id;
                }
            }

            $feedback = $form->values();

            $feedback['id'] = App::$db->insertRow('feedback', $form->values() + [
                    'user_id' => $user_id,
                    'date' => $this->timeFormat(time())
                ]);

            $feedback = $this->buildRow($logged_user, $feedback);
            $response->setData($feedback);
        } else {
            $response->setErrors($form->getErrors());
        }

        // Returns json-encoded response
        return $response->toJson();
    }


    /**
     * Formats row for json to be used in update method,
     * so that the data would be updated in the same format.
     *
     * @param $user
     * @param $feedback
     * @return array
     */
    private function buildRow($user, $feedback): array
    {
        return $row = [
            'id' => $feedback['id'],
            'name' => $user['name'],
            'comment' => $feedback['comment'],
            'date' => $this->timeFormat(time())
        ];
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