<?php


namespace App\Http\Controllers\Api\V1\Manager;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UsersController extends  Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'cpf' => 'required|unique:users,cpf',
            'rg' => 'required|unique:users,rg'
        ], [
            'name.required' => 'Nome do usuário é obrigatório',
            'name.length' => 'Nome deve conter no minimo 4 caracteres',
            'email.email' => 'Email precisa ser um endereço válido',
            'email.unique' => 'Email já está em uso no sistema',
            'role.required' => 'Tipo de usuário é obrigatório',
            'cpf.required' => 'CPF do usuário é obrigatório',
            'cpf.unique' => 'CPF do usuário já cadastrado',
            'rg.required' => 'RG do usuário é obrigatório',
            'rg.unique' => 'RG do usuário já cadastrado'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'title' => 'Erro',
                'status' => 'error',
                'message' => $validator->errors()->unique()
            ], 406);
        }

        $data = $request->all();

        $result = $this->service->create($data);

        if ($result['status'] == 'success') {
            return response()->json(['message' => 'Cadastro realizado com sucesso', 'status' => 'success', 'title' => 'Sucesso'], 201);
        } else if ($result['status'] == 'error') {
            return response()->json(['message' => $result['message'], 'status' => 'error', 'title' => 'Erro'], 400);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->service->getUsers($request->get('status'));
    }


    public function upload(Request $request)
    {
        $nameFile = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->image->storeAs('users', $nameFile, 'public');
            if (!$upload) {
                return response()->json(['message' => 'Verifique o arquivo enviado', 'status' => 'error','title' => 'Erro'], 400);
            } else {
                return response()->json(['file' => $nameFile]);
            }
        } else if($request->get('image') == null || $request->get('image') == ''){
            return response()->json(['file' => 'default.png']);
        } else {
            return response()->json(['message' => 'Verifique o arquivo enviado 1', 'status' => 'error','title' => 'Erro'], 400);
        }
    }
    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword($id, Request $request)
    {
        $validator = Validator($request->all(),
            [
                'password' => 'required|min:6'
            ],
            [
                'password.required' => 'Senha é obritaoria',
                'password.length' => 'Tamanho da senha invádio'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'title' => 'Erro',
                'status' => 'error',
                'message' => $validator->errors()->unique()
            ], 406);
        }

        $result = $this->service->updatePassword($id, $request->get('password'));

        if ($result['status'] == 'success') {
            return response()->json(['message' => 'Cadastro realizado com sucesso', 'status' => 'success', 'title' => 'Sucesso'], 201);
        } else if ($result['status'] == 'error') {
            return response()->json(['message' => $result['message'], 'status' => 'error', 'title' => 'Erro'], 400);
        }
    }

    /**
     * @return mixed
     */
    public function authenticated()
    {
        $user = \Auth::guard()->user();
        return $this->service->authenticated($user->id);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus($id, Request $request)
    {

        $result = $this->service->updateStatus($id);

        if ($result['status'] == 'success') {
            return response()->json(['message' => 'Status atualizado com sucesso', 'status' => 'success', 'title' => 'Sucesso'], 200);
        } else if ($result['status'] == 'error') {
            return response()->json(['message' => $result['message'], 'status' => 'error', 'title' => 'Erro'], 400);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|min:4',
            'role' => 'required'
        ], [
            'name.required' => 'Nome do usuário é obrigatório',
            'name.length' => 'Nome deve conter no minimo 4 caracteres',
            'role.required' => 'Nível de usuário é obrigatório'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'title' => 'Erro',
                'status' => 'error',
                'message' => $validator->errors()->unique()
            ], 406);
        }

        $result = $this->service->update($id, $request->all());

        if ($result['status'] == 'success') {
            return response()->json(['message' => 'Usuario atualizado com sucesso', 'status' => 'success', 'title' => 'Sucesso'], 200);
        } else if ($result['status'] == 'error') {
            return response()->json(['message' => $result['message'], 'status' => 'error', 'title' => 'Erro'], 400);
        }
    }

}