<template>
		<div v-if="loading" class="profile_container r-flex">
				Loading...
		</div>
		<div v-else class="profile_container__main">
			<h1 class="cabinet_header">
				ПРОФИЛЬ ЖИТЕЛЯ
			</h1>
			<div class="profile_content r-flex">
				<section class="contacts">
					<h3>
						{{profileLocal.lastName}} {{profileLocal.firstName}} {{profileLocal.patronymic}} <a href="#" v-show="disabled" @click.prevent="disabled=!disabled">Редактировать</a><a href="#" v-show="!disabled" @click.prevent="saveHandler">Сохранить</a><a href="#" v-show="!disabled" @click.prevent="cancelHandler">Отменить</a>
					</h3>
					<form name="contacts" method="post" action="#">
						<div class="r-flex">
							<label for="account">Лицевой счет №:</label>
							<input type="text" name="account"  :disabled="disabled" :class="disabled?'':'active_input'"/>
						</div>
						<div class="r-flex">
							<label for="house">Участок №, площадь:</label>
							<input type="text" name="house"  :disabled="disabled" :class="disabled?'':'active_input'"/>
						</div>
						<div class="r-flex">
							<label for="phone">Телефон:</label>
							<input type="tel" name="phone" v-model="profileLocal.phoneNumber" :disabled="disabled" :class="disabled?'':'active_input'"/>
						</div>
						<div class="r-flex">
							<label for="email" >Электронная почта:</label>
							<input type="email" name="email" v-model="profileLocal.email" :disabled="disabled" :class="disabled?'':'active_input'"/>
						</div>
						<div class="r-flex">
							<label for="registration_date" >Дата регистрации:</label>
							<input type="email" name="registration_date" disabled :class="disabled?'':'active_input'"/>
						</div>
						<div class="r-flex">
							<label for="last_activity" >Последняя активность:</label>
							<input type="email" name="last_activity" disabled :class="disabled?'':'active_input'"/>
						</div>
						<div class="r-flex">
							<label for="address" >Почтовый адрес:</label>
							<textarea name="address" v-model="profileLocal.address" :disabled="disabled" :class="disabled?'':'active_input'"></textarea>
						</div>
						<div class="r-flex" v-show="!disabled">
							<label for="name" >Имя:</label>
							<input name="name" v-model="profileLocal.firstName" :disabled="disabled" :class="disabled?'':'active_input'"></input>
						</div>
						<div class="r-flex" v-show="!disabled">
							<label for="secondname" >Отчество:</label>
							<input name="secondnanme" v-model="profileLocal.patronymic" :disabled="disabled" :class="disabled?'':'active_input'"></input>
						</div>
						<div class="r-flex" v-show="!disabled">
							<label for="lastname" >Фамилия:</label>
							<input name="lastname" v-model="profileLocal.lastName" :disabled="disabled" :class="disabled?'':'active_input'"></input>
						</div>
					</form>
					<div class="controls_box">
						<router-link to="" class="toBills_btn">Перейти к счетчикам</router-link> <router-link to="" class="toCounters_btn">Перейти к неоплаченным счетам</router-link>
					</div>
				</section>
			</div>
			
		</div>

</template>

<script>
   // @ is an alias to /src
	import {mapState, mapActions} from 'vuex';
	export default {
	  name: 'personalAdmin',
	  props: ['id'],
	  components: {
	  },
	  data: () => ({
		loading: false,
		disabled: true,
		profileLocal: {}
	  }),
	  computed: {
		...mapState(['profile'])
	  },
	  methods: {
		...mapActions(['fetchUser', 'updateUser']),
		saveHandler(){
		//console.log('save');
			this.updateUser(this.profileLocal)
				.then(
					user => {
						this.disabled = true;
					}
				)
		},
		cancelHandler(){
			this.disabled = !this.disabled;
			this.profileLocal = {...this.profile};
		}
	  },
	  mounted() {
		this.fetchUser(+this.id)
			.then(
				profile => this.profileLocal = {...profile}
				//console.log(this.profile)
			)
	  }
	}
</script>

<style scoped lang="sass">
	.profile_container__main
		width: 100%
	.profile_content,
	.contacts
		width: 100%
	.toCounters_btn,
	.toBills_btn
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background: #C0BFFF
		border-radius: 10px
		padding: 5px 30px
		font-weight: 500
		font-size: 18px
		line-height: 22px
	label
		min-width: 200px
	.active_input
		border: 1px solid #000
	.profile_content form div:first-child input
		margin: 0 0 0 20px
		
</style>