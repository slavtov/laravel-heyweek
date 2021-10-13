@include('includes.button', [
  'name' => 'home.dashboard',
  'route' => 'admin.dashboard'
])
@include('includes.button', [
  'name' => 'home.posts',
  'route' => 'admin.posts'
])
@include('includes.button', [
  'name' => 'home.users',
  'route' => 'users.index'
])
@can('categories')
  @include('includes.button', [
    'name' => 'home.categories',
    'route' => 'categories.index'
  ])
@endcan
@include('includes.button', [
  'name' => 'home.comments',
  'route' => 'comments.index'
])
@can('cache')
  @include('includes.button', [
    'name' => 'Cache',
    'route' => 'cache.index'
  ])
@endcan
@can('roles')
  @include('includes.button', [
    'name' => 'home.roles',
    'route' => 'roles.index'
  ])
@endcan
@can('permissions')
  @include('includes.button', [
    'name' => 'home.permissions',
    'route' => 'permissions.index'
  ])
@endcan
