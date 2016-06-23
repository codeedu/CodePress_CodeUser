<?php

namespace CodePress\CodeUser\Controllers\Admin;

use CodePress\CodeUser\Controllers\Controller;
use CodePress\CodeUser\Repository\RoleRepositoryInterface;
use CodePress\CodeUser\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    private $repository;
    private $response;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    public function __construct(
        ResponseFactory $response,
        UserRepositoryInterface $repository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->repository = $repository;
        $this->response = $response;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $users = $this->repository->all();
        return $this->response->view('codeuser::admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roleRepository->lists('name', 'id');
        $users = $this->repository->all();
        return view('codeuser::admin.user.create', compact('users','roles'));
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
        $user = $this->repository->find($id);
        $users = $this->repository->all();
        return $this->response->view('codeuser::admin.user.edit', compact('user', 'users'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $category = $this->repository->update($data, $id);
        return redirect()->route('admin.users.index');
    }

}