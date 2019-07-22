<?php


namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * SellerService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getUsers($limit)
    {
        return $this->userRepository->skipPresenter(false)->listUsers($limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getId($id)
    {
        return $this->userRepository->skipPresenter(false)->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function authenticated($id)
    {
        $user = $this->userRepository->find($id);

        $user->last_login_at = Carbon::now()->toDateTimeString();

        $user->save();

        return $this->userRepository->skipPresenter(false)->find($id);
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {

            $data['remember_token'] = str_random(10);

            $data['email_verified_at'] = new \DateTime();

            $data['password'] = bcrypt(123456);

            $result = $this->userRepository->create($data);

            if ($result->role == 'user_company') {

                $protocols = $data['protocols'];
                for ($i = 0; $i < count($protocols); $i++) {
                    //foreach($protocols as $protocol) {
                    $data = [
                        "user_id" => $result->id,
                        "protocol_id" => $protocols[$i]["id"]
                    ];

                    $this->protocolRepository->create($data);
                }
            }

            DB::commit();

            return ['status' => 'success', 'id' => $result->id];

        } catch (\Exception $exception) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $exception->getMessage(), 'title' => 'Erro'];
        }
    }

    /**
     * @param $id
     * @param $password
     * @return array
     */
    public function updatePassword($id, $password)
    {
        DB::beginTransaction();
        try {

            $user = $this->userRepository->find($id);

            $user->password = bcrypt($password);

            $user->save();
            DB::commit();
            return ['status' => 'success', 'id' => $user->id];
        } catch (\Exception $exception) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $exception->getMessage(), 'title' => 'Erro'];
        }
    }

    /**
     * @param $id
     * @param $password
     * @return array
     */
    public function updateStatus($id)
    {
        DB::beginTransaction();
        try {

            $user = $this->userRepository->find($id);

            if ($user->status == 'ativo') {
                $user->status = 'inativo';
            } else {
                $user->status = 'ativo';
            }

            $user->save();

            DB::commit();
            return ['status' => 'success', 'id' => $user->id];

        } catch (\Exception $exception) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $exception->getMessage(), 'title' => 'Erro'];
        }
    }

    /**
     * @param $data
     * @param $id
     * @return array
     */
    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            //$user = $this->userRepository->find($id);
            $this->userRepository->update($data, $id);

            DB::commit();

            return ['status' => 'success'];
        } catch (\Exception $exception) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $exception->getMessage(), 'title' => 'Erro'];
        }
    }

}