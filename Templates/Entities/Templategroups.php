<?php
	
	namespace Modules\Templates\Entities;
	
	use App\Rewrite\Database\Eloquent\Model;
	
	class Templategroups extends Model
	{
		protected $table = 'templates_groups';
		protected $fillable
		                 = [
				'name',
				'code',
				'description',
				'templates'
			];
	}
