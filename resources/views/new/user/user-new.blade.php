@extends('view.layouts.login')
@section('css')
<link href="{{ URL::asset('assets/style.css') }}" rel="stylesheet">
@endsection
@section('title', 'Cadastro de Usuário')
@section('content')
@if (isset($error))
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>{{ $error }}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<script>
		setTimeout(function() {
			$('.alert').alert('close')
		}, 5000);
	</script>
@endif
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
        <ul class="mb-0">
			<li><strong>{{ $errors->first() }}</strong></li>
        </ul>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
    </div>
	<script>
		setTimeout(function() {
			$('.alert').alert('close')
		}, 5000);
	</script>
@endif
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Cadastro</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
				<form id="login-form" method="POST" action="{{ route('user.post.new') }}">
                    @csrf
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="Nome" id="name" name="name">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="Email" id="email" name="email">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Informe sua senha" id="password" name="password">
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Comfirme sua senha" id="password-confirm" name="password-confirm">
					</div>
					<div class="form-group">
						<input type="submit" value="Cadastrar" class="btn float-right register_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Já tem uma conta?<a href="{{ route('home.get') }}">Entre</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
