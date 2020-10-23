<template>
		<div v-if="loading" class="profile_container r-flex">
				Loading...
		</div>
		<div v-else class="profile_container__main">
			<h1 class="cabinet_header">
				ПРОФИЛЬ
			</h1>
			<div class="profile_top r-flex">
				<div class="profile_top_left">
					<img src="" alt="avatar" />
					<h2>
						{{profile.user.firstName}} {{profile.user.lastName}}
					</h2>
				</div>
				<aside class="">
					<a href="#">
						<i class="fas fa-pencil-alt"></i> 
						Фото
					</a>
					<a href="#" id="fio_link" @click.prevent="FIO_show=!FIO_show">
						<i class="fas fa-pencil-alt"></i>
						Фамилия и Имя
					</a>
					<a href="#" @click.prevent="Phone_show=!Phone_show">
						<i class="fas fa-pencil-alt"></i>
						Телефон
					</a>
					<a href="#" @click.prevent="Email_show=!Email_show">
						<i class="fas fa-pencil-alt"></i>
						Электронная почта
					</a>
					<a href="#" @click.prevent="Address_show=!Address_show">
						<i class="fas fa-pencil-alt"></i>
						Почтовый адрес
					</a>
					<a href="#" @click.prevent="Password_show=!Password_show">
						<i class="fas fa-pencil-alt"></i>
						Сменить пароль
					</a>
				</aside>
			</div>
			<div class="profile_content r-flex">
				<section class="contacts_data">
					<h3>
						Контактные данные:
					</h3>
					<form name="contacts" method="post" action="#">
						<div class="r-flex">
							<label for="phone">Телефон:</label>
							<input type="tel" name="phone" v-model="profile.user.phoneNumber" disabled/>
						</div>
						<div class="r-flex">
							<label for="email" >Электронная почта:</label>
							<input type="email" name="email" v-model="profile.user.email" disabled/>
						</div>
						<div class="r-flex">
							<label for="address" >Почтовый адрес:</label>
							<textarea name="address" disabled v-model="profile.user.address"></textarea>
						</div>
					</form>
				</section>
				<section class="profile_address">
					<h3>
						Мои адреса:
					</h3>
					<p v-for="(account, i) in profile.accounts" :key="account.id">
						{{i+1}}. {{account.address}}, <b>участок № {{account.houseNumber}}</b>
						<br/>
						<span>
							- площадь участка: <b>{{account.acresAmount}} соток</b>.
						</span>
					</p>
				</section>
			</div>
			<div v-show="FIO_show" id="profile_fio" :class="[modal, FIO_show ? pointer_events_on : '']">
			<div class="r-flex">
				<p id="close_modal fio" class="modal_close">
					<a href="#" class="close_X" id="fio_close_X" @click.prevent="FIO_show=!FIO_show">
						X
					</a>
				</p>
				<h2>
					Имя, Отчество, Фамилия
				</h2>
				<form name="profile_fio" id="profile_form" action="#" method="post" class="r-flex">
					<input type="text" placeholder="Имя" id="firstname" name="firstname" :value="profile.user.firstName"/>
					<input type="text" placeholder="Отчество" id="secondname" name="secondname" :value="profile.user.patronymic"/>
					<input type="text" placeholder="Фамилия" id="lastname" name="lastname" :value="profile.user.lastName"/>
					<div class="login_controls r-flex">
						<input type="button" name="cancel" id="cancel_fio" @click.prevent="FIO_show=!FIO_show" value="Отменить"></input>
						<input type="submit" name="submit" id="submit_fio" value="Сохранить" @click.prevent="changeFIO"></input>
					</div>
				</form>
			</div>
		</div><!--FIO-modal-->
		<div v-show="Phone_show" id="profile_phone" :class="[modal, Phone_show ? pointer_events_on : '']">
			<div class="r-flex">
				<p id="close_modal fio" class="modal_close">
					<a href="#" class="close_X" id="fio_close_X" @click.prevent="Phone_show=!Phone_show">
						X
					</a>
				</p>
				<h2>
					Телефон
				</h2>
				<form name="profile_phone" id="profile_form_phone" action="#" method="post" class="r-flex">
					<input type="tel" id="phonenumber" name="phonenumber" :value="profile.user.phoneNumber"/>
					<div class="login_controls r-flex">
						<input type="button" name="cancel" id="cancel_fio" @click.prevent="Phone_show=!Phone_show" value="Отменить"></input>
						<input type="submit" name="submit" id="submit_fio" value="Сохранить" @click.prevent="changephoneNumber"></input>
					</div>
				</form>
			</div>
		</div><!--Phone-modal-->
		<div v-show="Email_show" id="profile_form_email" :class="[modal, Email_show ? pointer_events_on : '']">
			<div class="r-flex">
				<p id="close_modal fio" class="modal_close">
					<a href="#" class="close_X" id="fio_close_X" @click.prevent="Email_show=!Email_show">
						X
					</a>
				</p>
				<h2>
					Электронная почта
				</h2>
				<form name="profile_email" id="profile_form_email" action="#" method="post" class="r-flex">
					<input type="email" id="email" name="email" :value="profile.user.email"/>
					<div class="login_controls r-flex">
						<input type="button" name="cancel" id="cancel_email" @click.prevent="Email_show=!Email_show" value="Отменить"></input>
						<input type="submit" name="submit" id="submit_email" value="Сохранить" @click.prevent="changeEmail"></input>
					</div>
				</form>
			</div>
		</div><!--Email-modal-->
		<div v-show="Address_show" id="profile_form_address" :class="[modal, Address_show ? pointer_events_on : '']">
			<div class="r-flex">
				<p id="close_modal fio" class="modal_close">
					<a href="#" class="close_X" id="fio_close_X" @click.prevent="Address_show=!Address_show">
						X
					</a>
				</p>
				<h2>
					Почтовый адрес
				</h2>
				<form name="profile_address" id="profile_form_address" action="#" method="post" class="r-flex">
					<input type="text" id="address" name="address" :value="profile.user.address"/>
					<div class="login_controls r-flex">
						<input type="button" name="cancel" id="cancel_address" @click.prevent="Address_show=!Address_show" value="Отменить"></input>
						<input type="submit" name="submit" id="submit_address" value="Сохранить" @click.prevent="changeAddress"></input>
					</div>
				</form>
			</div>
		</div><!--Address-modal-->
		<div v-show="Password_show" id="profile_form_address" :class="[modal, Password_show ? pointer_events_on : '']">
			<div class="r-flex">
				<p id="close_modal fio" class="modal_close">
					<a href="#" class="close_X" id="fio_close_X" @click.prevent="cancelPasswordChange">
						X
					</a>
				</p>
				<h2>
					Изменить пароль
				</h2>
				<form name="profile_address" id="profile_form_address" action="#" method="post" class="r-flex">
					<input type="password" name="oldPassword" v-model="passwords.oldPassword" placeholder="старый пароль"/>
					<input type="password" name="newPassword" v-model="passwords.newPassword" placeholder="новый пароль"/>
					<input type="password" name="newPasswordRepeat" v-model="passwords.newPasswordRepeat" placeholder="новый пароль ещё раз"/>
					<div class="login_controls r-flex">
						<input type="button" name="cancel" id="cancel_address" @click.prevent="cancelPasswordChange" value="Отменить"></input>
						<input type="submit" name="submit" id="submit_address" value="Сохранить" @click.prevent="changePasswordHandler"></input>
					</div>
				</form>
			</div>
		</div><!--Password-modal-->
		</div>

</template>

<script>
   // @ is an alias to /src
	import {mapState, mapActions} from 'vuex';
	export default {
	  name: 'personal',
	  components: {
		//Posts
	  },
	  data: () => ({
		loading: false,
		FIO_show: false,
		Phone_show: false,
		Email_show: false,
		Address_show: false,
		Password_show: false,
		modal: 'modal_profile',
		pointer_events_on: 'pointer_events_on',
		passwords: {
			newPassword: '',
			newPasswordRepeat: '',
			oldPassword: ''
		}
	  }),
	  computed: {
		...mapState(['profile']),
	  },
	  methods: {
	    ...mapActions(['logout', 'changePassword']),
		changeFIO(){
			let firstname = document.getElementById('firstname').value;
			let lastname = document.getElementById('lastname').value;
			let secondname = document.getElementById('secondname').value;
			this.profile.user.firstName = firstname;
			this.profile.user.lastName = lastname;
			this.profile.user.patronymic = secondname;
			
			this.updateProfile(this.profile.user)
				.then(updatedProfile => {
					this.FIO_show = false;
				})
			
		},
		changephoneNumber(){
			let phoneNumber = document.getElementById('phonenumber').value;
			this.profile.user.phoneNumber = phoneNumber;
			this.updateProfile(this.profile.user)
				.then(updatedProfile => {
					this.Phone_show = false;
					/*
					this.$store.dispatch('logout')
						.then(
							() => {
								if(window.location.pathname === '/') this.$forceUpdate();
								else this.$router.push('/');
							}
						)
						*/
				})
		},
		changeEmail(){
			let email = document.getElementById('email').value;
			this.profile.user.email = email;
			this.updateProfile(this.profile.user)
				.then(
					() => {
						this.Email_show = false;
					}
				)
		},
		changeAddress(){
			let address = document.getElementById('address').value;
			this.profile.user.address = address;
			this.updateProfile(this.profile.user)
				.then(
					() => {
						this.Address_show = false;
					}
				)
		},
		cancelPasswordChange(){
			this.Password_show=!this.Password_show;
			this.passwords.oldPassword = '';
			this.passwords.newPassword = '';
			this.passwords.newPasswordRepeat = '';
		},
		changePasswordHandler(){
			let auth = {
				  "newPassword": this.passwords.newPassword,
				  "newPasswordConfirm": this.passwords.newPasswordRepeat,
				  "oldPassword": this.passwords.oldPassword,
				  "username": this.profile.user.username
				}
			this.Password_show = !this.Password_show;
			this.changePassword(auth)
				.then(
					() => {
							this.logout()
								.then(
									() => this.$router.push({ name: 'home' })
								)
						}
				)
		},
		updateProfile(newProfile){
			return this.$store.dispatch('updateProfile', newProfile)
		}
	  },
	  mounted() {
		this.loading = true;
		this.$store.dispatch('fetchProfile')
		.then( profile => {
			this.loading = false;
		})
	  }
	}
</script>

<style scoped lang="sass">
	
</style>