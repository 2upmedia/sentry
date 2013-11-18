<?php namespace Cartalyst\Sentry\Permissions;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

class EloquentPermissions extends BasePermissions implements PermissionsInterface {

	/**
	 * Associated user.
	 *
	 * @var \Cartalyst\Sentry\Users\UserInterface
	 */
	protected $user;

	/**
	 * Flag for whether permissions have been loaded.
	 *
	 * @var bool
	 */
	protected $loadedPermissions = false;

	/**
	 * Create a new Eloquent permissions instance.
	 *
	 * @param  \Cartalyst\Sentry\Users\UserInterface  $user
	 */
	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasAccess($permissions)
	{
		if ($this->loadedPermissions === false)
		{
			$this->loadPermissions();
			$this->loadedPermissions = true;
		}

		return parent::hasAccess($permissions);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasAnyAccess($permissions)
	{
		if ($this->loadedPermissions === false)
		{
			$this->loadPermissions();
			$this->loadedPermissions = true;
		}

		return parent::hasAnyAccess($permissions);
	}

	/**
	 * Loads permissions from the User instance.
	 *
	 * @return void
	 */
	protected function loadPermissions()
	{
		$this->userPermissions = $this->user->permissions;

		foreach ($this->user->groups as $group)
		{
			$this->groupPermissions[] = $group->permissions;
		}
	}

}
