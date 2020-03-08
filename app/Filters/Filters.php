<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters 
{
	protected $request, $builder, $filters = [];
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}
	
	public function apply($builder)
	{
		$this->builder = $builder;

		// dd($this->getFilters());

		foreach ($this->getFilters() as $filter => $value)
		{
			if (method_exists($this, $filter)) {
				$this->$filter($value);
			}

			// if (!$this->hasFilter($filter)) return;
			
			// $this->$filter($this->request->$filter);
			
		}

		// if($this->request->has('by')) {
		// 	$this->by($this->request->by);
		// }

		return $this->builder;
		
	}

	// protected function hasFilter($filter)
	// {
	// 	return method_exists($this, $filter) && $this->request->has($filter);
	// }

	public function getFilters()
	{
		return $this->intersect($this->filters);
	}

	public function intersect($keys)
	{
		return array_filter($this->request->only(is_array($keys) ? $keys : func_get_args()));
	}
}