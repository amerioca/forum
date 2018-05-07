<?php 

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters {

	/**
	 * [$request description]
	 * @var [type]
	 */
	protected $request;
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->request = $request;
	}
	public function apply($builder)
	{
		if(! $username = $this->request->by) return $builder;

		$user = User::where('name', $username)->firstOrFail();

		return $builder->where('user_id', $user->id);	
	}
}

 ?>