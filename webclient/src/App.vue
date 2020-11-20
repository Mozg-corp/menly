<template>
  <div class="wrapper">
		<div class="top">
			<header class="app_header">
				<b-container class="pt-1">
					<b-row align-v="center">
						<b-col >
							<fa-icon 
								v-if="isLogined"
								v-b-toggle.menu :icon="['fas', 'bars']" />
						</b-col>
						<b-col class="d-flex justify-content-center">
							<svg width="99" height="38" viewBox="0 0 99 38" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M76.1052 22.4545V0" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M41.7871 22.7013C37.1984 22.7013 33.5371 18.9506 33.5371 14.361C33.5371 9.7714 37.2472 6.02075 41.7871 6.02075C46.327 6.02075 50.0371 9.7714 50.0371 14.361" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M50.8182 14.3116H41.7871" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M54.6746 14.3117C54.6746 9.67273 58.3846 5.97144 62.9246 5.97144C67.5133 5.97144 71.1746 9.72208 71.1746 14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M54.6746 22.4546V5.97144" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M62.9734 5.97144C67.5621 5.97144 71.2234 9.72208 71.2234 14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M71.2234 22.4546V14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M0.488281 14.3117C0.488281 9.67273 3.71017 5.97144 7.71313 5.97144C11.7161 5.97144 14.938 9.72208 14.938 14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M0.488281 22.4546V5.97144" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M7.71313 5.97144C11.7161 5.97144 14.938 9.72208 14.938 14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M14.938 22.4546V14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M14.938 14.3117C14.938 9.67273 18.1599 5.97144 22.1628 5.97144C26.1658 5.97144 29.3877 9.72208 29.3877 14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M22.1628 5.97144C26.1658 5.97144 29.3877 9.72208 29.3877 14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M29.3877 22.4546V14.3117" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M81.9631 14.4104C81.9631 19.0494 85.6732 22.7507 90.2131 22.7507C94.8019 22.7507 98.4631 19 98.4631 14.4104" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M90.2131 37.5065C94.8019 37.5065 98.4631 33.7559 98.4631 29.1663" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M81.9631 14.4104V5.97144" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
								<path d="M98.512 29.1662V5.97144" stroke="#222220" stroke-width="2" stroke-miterlimit="10"/>
							</svg>

						</b-col>
						<b-col class="d-flex flex-row-reverse">
							<div>
								<b-button 
									v-if="!isLogined" 
									size="sm" 
									variant="outline-secondary" 
									class="text-right app_header__login"
									v-b-modal.signin
								>
										Войти
								</b-button>
								<fa-icon 
									v-else
									:icon="['fas', 'sign-out-alt']"
									@click.prevent="logoutHandler"
								/>
							</div>
						</b-col>
					</b-row>
				</b-container>	
			</header><!--header-->
			<router-view></router-view>
			<b-modal 
				centered 
				id="signin" 
				title="Авторизация"
				@ok="OkHandler"
			>
				<form ref="form" @submit.stop.prevent="signInHandler">
					<b-form-group
						:state="valid"
						label="Телефон"
						label-for="phone-input"
						:invalid-feedback="errors.phone?errors.phone[0]:''"
					>
						<b-form-input
							id="phone-input"
							v-model="login"
							:state="valid"
							required
							placeholder="7(___)_______"
						></b-form-input>
					</b-form-group>
					<b-form-group
						:state="valid"
						label="Пароль"
						label-for="password-input"
						:invalid-feedback="errors.password?errors.password[0]:''"
					>
						<b-form-input
							id="password-input"
							v-model="password"
							:state="valid"
							required
							type="password"
						></b-form-input>
					</b-form-group>
				</form>
			</b-modal>
			<b-sidebar id="menu" title="Меню" shadow>
			  <nav class="mb-3">
				<b-nav vertical>
				  <b-nav-item active >Active</b-nav-item>
				  <b-nav-item href="#link-1">Link</b-nav-item>
				  <b-nav-item href="#link-2">Another Link</b-nav-item>
				</b-nav>
			  </nav>
			</b-sidebar>
		</div> <!--top-->
		<footer>
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
			valid: null,
			password: '',
			login: '',
			reg_login: '',
			reg_password: '',
			reg_password_repeat: '',
			errors: {}
        }),
		computed: {
			isLogined(){
				return this.$store.getters.isAuthenticated;
			},
			...mapState(['username', 'userId', 'user']),
			...mapGetters(['isAdmin', 'isAuthenticated']),
			
		},
        methods: {
			...mapActions(['signIn', 'logout']),
            logoutHandler(){
              this.logout()
                  .then(()=>{
					if(window.location.pathname !== '/') this.$router.push('/');
                  })
            },
            OkHandler(bvModalEvt){
				bvModalEvt.preventDefault();
				this.signInHandler();
			},
			signInHandler(){
				let bodyFormData = new FormData();
				bodyFormData.set('User[phone]', this.login);
				bodyFormData.set('User[password]', this.password);
				this.signIn(bodyFormData)
					.then(
						()=>{
							this.valid = true;
							this.$nextTick(() => {
								this.$bvModal.hide('signin');
							})
						}
					)
					.catch(
						({errors})=>{
							this.valid = false;
							this.errors = errors;
						}
					);
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
		/*
			if(this.userId){
				this.fetchUserData(this.userId)
					.then(
						()=> {
							
						}
					);
			}
			*/
			//this.fetchAgregatorsList()
				
			//this.username = this.$store.getters.getUsername;
			//this.isLogined = this.$store.getters.isAuthenticated;
        },
		updated(){
		
		}

    };
</script>
<style scoped lang="sass">
	.app_header
		box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.05)
		&__login
			font-weight: 300
			font-size: 12px
			line-height: 15px
			color: #000
	.login_active
		display: block
		pointer-events: auto
	.logged > a:first-child
		font-size: 14px
		line-height: 17px
		display: block

</style>