<template>
  <div class="wrapper">
		<div class="top">
			<header>
				<div class="container_my r-flex">
					<div class="header_left">
						<p class="logo_text">
							 MENLY.RU
						</p>
					</div>
					<div class="header_center r-flex">
						<nav id="nav-menu-container_my">
							<ul class="menu r-flex">
								<router-link :to="{name: 'home'}">
									<li >
											главная
									</li>
								</router-link>
								<router-link :to="{name: 'about'}">
									<li>
											о нас
									</li>
								</router-link>
								<!--<a href="./pages/foto.html">-->
								<!--	<li>-->
								<!--			фото-->
								<!--	</li>-->
								<!--</a>-->
								<!--<a href="#">-->
								<!--	<li>-->
								<!--		документы-->
								<!--	</li>-->
								<!--</a>-->
								<!--<router-link :to="{name: 'claims'}">-->
								<!--	<li>-->
								<!--			обращения-->
								<!--	</li>-->
								</router-link>
								<!--<a href="#">-->
								<!--	<li>-->
								<!--		голосования-->
								<!--	</li>-->
								<!--</a>-->
								<router-link :to="{name: 'contacts'}">
									<li>
											контакты
									</li>
								</router-link>
								<router-link v-show="isLogined" :to="{name: 'personal'}">
									<li>
											личный кабинет
									</li>
								</router-link>
								<router-link v-show="isAdmin===true" :to="{name: 'cityzens'}">
									<li>
											управление снт
									</li>
								</router-link>
							</ul>
						</nav>
					</div>
					<div class="header_right">
						<div v-show="!isLogined" class="notlogged">
							<a href="#" id="login" @click.prevent="showModal = !showModal">
								войти
							</a>
							<a href="#" id="register" @click.prevent="showRegistrationModal = !showRegistrationModal">
								зарегистрироваться
							</a>
						</div>
						<div v-show="isLogined" class="logged">
							<router-link v-if="isAdmin!==true" :to="{name: 'personal'}">
								{{username}}
							</router-link>
							<router-link v-else :to="{name: 'cityzens'}">
								{{username}}
							</router-link>
							<a href="#" @click.prevent="logout">
								выход
							</a>
						</div>
					</div>
				</div>
			</header><!--header-->
			<router-view></router-view>
			<div id="loginForm" :class="[modal, showModal? login_show : '']" >
				<div class="r-flex">
					<p id="close_modal" class="modal_close">
						<a href="#" class="close_X" id="close_X" @click.prevent="showModal=!showModal">
							X
						</a>
					</p>
					<h2>
						АВТОРИЗАЦИЯ
					</h2>
					<form name="login" id="login" action="#" method="post" class="r-flex">
						<input type="text" name="phone" placeholder="Телефон" v-model="login"/>
						<input type="password" name="password" placeholder="ПАРОЛЬ" v-model="password"/>
						<div class="login_controls r-flex">
							<input type="submit" name="submit" value="вход" @click.prevent="signIn"></input>
							<input type="button" name="cancel" value="отмена" @click.prevent="showModal=!showModal"></input>
						</div>
					</form>
				</div>
			</div>
			<div id="signUpForm" :class="[modal, showRegistrationModal? login_show : '']" >
				<div class="r-flex">
					<p id="close_modal" class="modal_close">
						<a href="#" class="close_X" id="close_X" @click.prevent="showRegistrationModal=!showRegistrationModal">
							X
						</a>
					</p>
					<h2>
						Регистрация
					</h2>
					<form name="login" id="login" action="#" method="post" class="r-flex">
						<input type="text" name="phone" placeholder="Телефон" v-model="reg_login"/>
						<input type="password" name="password" placeholder="ПАРОЛЬ" v-model="reg_password"/>
						<input type="password" name="password_repeat" placeholder="ПАРОЛЬ ЕЩЁ РАЗ" v-model="reg_password_repeat"/>
						<div class="login_controls r-flex">
							<input type="submit" name="submit" value="вход" @click.prevent="signUp"></input>
							<input type="button" name="cancel" value="отмена" @click.prevent="showRegistrationModal=!showRegistrationModal"></input>
						</div>
					</form>
				</div>
			</div>
		</div> <!--top-->
		<footer>
			<div class="container_my_my">
			</div>
		</footer> <!--footer-->
	</div> <!--wrapper-->
</template>

<script>
    import store from './store/index';
	import {mapState, mapGetters, mapActions} from 'vuex';
    export default {
		name: 'Layout',
        components: {
        },
        data: () => ({
			showModal: false,
			showRegistrationModal: false,
			modal: 'modal',
			login_show: 'login_active',
			password: '',
			login: '',
			reg_login: '',
			reg_password: '',
			reg_password_repeat: ''
        }),
		computed: {
			isLogined(){
				return this.$store.getters.isAuthenticated;
			},
			...mapState(['username', 'userId', 'user']),
			...mapGetters(['isAdmin']),
			
		},
        methods: {
			...mapActions(['fetchAgregatorsList', 'fetchUserData']),
            logout(){
              this.$store.dispatch('logout')
                  .then(()=>{
					if(window.location.pathname !== '/') this.$router.push('/');
                  })
            },
            signIn(){
					let bodyFormData = new FormData();
                    bodyFormData.set('User[phone]', this.login);
                    bodyFormData.set('User[password]', this.password);
                    this.$store.dispatch('signIn', bodyFormData)
                        .then(()=>{
							this.showModal = !this.showModal
                        })
                        .catch();
            },
            signUp(){
                let bodyFormData = new FormData();
                    bodyFormData.set('User[phone]', this.reg_login);
                    bodyFormData.set('User[password]', this.reg_password);
                    bodyFormData.set('User[password_repeat]', this.reg_password_repeat);
                    this.$store.dispatch('signUp', bodyFormData)
                        .then(()=>{
							this.showRegistrationModal = !this.showRegistrationModal
                        })
                        .catch();
            }

        },
        mounted() {
			this.fetchUserData(this.userId);
			this.fetchAgregatorsList()
				
			//this.username = this.$store.getters.getUsername;
			//this.isLogined = this.$store.getters.isAuthenticated;
        },
		updated(){
		
		}

    };
</script>
<style scoped lang="sass">
	.login_active
		display: block
		pointer-events: auto
	.logged > a:first-child
		font-size: 14px
		line-height: 17px
		display: block

</style>