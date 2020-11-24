<template>
<div>
	<div class="personal_top">
		<b-container>
			<h2 class="personal_top_heading">
				Личные данные
			</h2>
		</b-container>
	</div>
	<b-container class="pt-3">
		<h3 class="personal_heading">
			Заполни все пустые поля
		</h3>
		<div v-show="!user.profile">
			<b-row align-h="center">
				<b-col 
					cols="10"
				>
					<span class="personal_general__heading">
						Личные данные
					</span>
					<fa-icon 
						v-show="collapse.general"
						:icon="['fas', 'chevron-circle-up']"
						@click="collapse.general=!collapse.general"
					>
					</fa-icon>
					<fa-icon 
						v-show="!collapse.general"
						:icon="['fas', 'chevron-circle-down']"
						@click="collapse.general=!collapse.general"
					>
					</fa-icon>
				</b-col>
				<b-col
					sm="6"
				>
					
					<b-collapse 
						v-model="collapse.general" 
						id="collapse-general" 
						class="mt-2"
					>
						<b-form>
						  <b-form-group
							id="input-group-1"
							label="Фамилия:"
							label-for="input-1"
						  >
							<b-form-input
							  id="input-1"
							  v-model="profile.lastname"
							  required
							  placeholder="Фамилия"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-2" 
							label="Имя:" 
							label-for="input-2"
						  >
							<b-form-input
							  id="input-2"
							  v-model="profile.firstname"
							  required
							  placeholder="Имя"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-3" 
							label="Отчество:" 
							label-for="input-3"
						  >
							<b-form-input
							  id="input-3"
							  v-model="profile.secondname"
							  required
							  placeholder="Отчество"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-5" 
							label="Номер телефона:" 
							label-for="input-5"
						  >
							<b-form-input
							  id="input-5"
							  v-model="profile.phone"
							  required
							  placeholder="Номер телефона"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-4" 
							label="Дата рождения:" 
							label-for="input-4"
						  >
							<b-form-input
							  id="input-4"
							  v-model="profile.birthdate"
							  required
							  type="date"
							  placeholder="дд.мм.гггг"
							></b-form-input>
						  </b-form-group>
						</b-form>
						<b-col class="d-flex justify-content-center">
							<b-button 
								size="sm"
								variant="dark"
								class="text-center"
								@click.prevent="generalGoHandler"
							>
								Дальше
							</b-button>
						</b-col>
					</b-collapse>
				</b-col>
				<b-col 
					cols="10"
				>
					<span class="personal_general__heading">
						Паспортные данные
					</span>
					<fa-icon 
						v-show="collapse.passport"
						:icon="['fas', 'chevron-circle-up']"
						@click="collapse.passport=!collapse.passport"
					>
					</fa-icon>
					<fa-icon 
						v-show="!collapse.passport"
						:icon="['fas', 'chevron-circle-down']"
						@click="collapse.passport=!collapse.passport"
					>
					</fa-icon>
				</b-col>
				<b-col
					sm="6"
				>
					
					<b-collapse 
						v-model="collapse.passport" 
						id="collapse-passport" 
						class="mt-2"
					>
						<b-form>
						  <b-form-group
							id="input-group-21"
							label="Серия:"
							label-for="input-21"
						  >
							<b-form-input
							  id="input-21"
							  v-model="profile.passport_series"
							  required
							  placeholder="Серия"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-22" 
							label="Номер:" 
							label-for="input-22"
						  >
							<b-form-input
							  id="input-22"
							  v-model="profile.passport_number"
							  required
							  placeholder="Номер"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-23" 
							label="Кем выдан:" 
							label-for="input-23"
						  >
							<b-form-input
							  id="input-3"
							  v-model="profile.passport_giver"
							  required
							  placeholder="Кем выдан"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-24" 
							label="Дата выдачи:" 
							label-for="input-24"
						  >
							<b-form-input
							  id="input-24"
							  v-model="profile.passport_date"
							  required
							  type="date"
							  placeholder="дд.мм.гггг"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-23" 
							label="Адрес регистрации:" 
							label-for="input-23"
						  >
							<b-form-input
							  id="input-23"
							  v-model="profile.registration_address"
							  required
							  placeholder="Адрес регистрации"
							></b-form-input>
						  </b-form-group>
						</b-form>
						<b-col class="d-flex justify-content-center">
							<b-button 
								size="sm"
								variant="dark"
								class="text-center"
								@click.prevent="passportGoHandler"
							>
								Дальше
							</b-button>
						</b-col>
					</b-collapse>
				</b-col>
				<b-col 
					cols="10"
				>
					<span class="personal_general__heading">
						Данные водительского удостоверения
					</span>
					<fa-icon 
						v-show="collapse.license"
						:icon="['fas', 'chevron-circle-up']"
						@click="collapse.license=!collapse.license"
					>
					</fa-icon>
					<fa-icon 
						v-show="!collapse.license"
						:icon="['fas', 'chevron-circle-down']"
						@click="collapse.license=!collapse.license"
					>
					</fa-icon>
				</b-col>
				<b-col
					sm="6"
				>
					
					<b-collapse 
						v-model="collapse.license" 
						id="collapse-license" 
						class="mt-2"
					>
						<b-form>
						  <b-form-group
							id="input-group-31"
							label="Серия:"
							label-for="input-31"
						  >
							<b-form-input
							  id="input-31"
							  v-model="profile.license_series"
							  required
							  placeholder="Серия"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-22" 
							label="Номер:" 
							label-for="input-22"
						  >
							<b-form-input
							  id="input-22"
							  v-model="profile.license_number"
							  required
							  placeholder="Номер"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-24" 
							label="Дата выдачи:" 
							label-for="input-24"
						  >
							<b-form-input
							  id="input-24"
							  v-model="profile.license_date"
							  required
							  type="date"
							  placeholder="дд.мм.гггг"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-24" 
							label="Дата истекания:" 
							label-for="input-24"
						  >
							<b-form-input
							  id="input-24"
							  v-model="profile.license_expire"
							  required
							  type="date"
							  placeholder="дд.мм.гггг"
							></b-form-input>
						  </b-form-group>
						</b-form>
						<b-col class="d-flex justify-content-center">
							<b-button 
								size="sm"
								variant="dark"
								class="text-center"
								@click.prevent="saveProfileHandler"
							>
								Сохранить
							</b-button>
						</b-col>
					</b-collapse>
				</b-col>
			</b-row>
		</div>
		<div v-show="!user.car">
			<b-row align-h="center">
				<b-col 
					cols="10"
				>
					<span class="personal_general__heading">
						Данные транспортного средства
					</span>
					<fa-icon 
						v-show="collapse.car"
						:icon="['fas', 'chevron-circle-up']"
						@click="collapse.car=!collapse.car"
					>
					</fa-icon>
					<fa-icon 
						v-show="!collapse.car"
						:icon="['fas', 'chevron-circle-down']"
						@click="collapse.car=!collapse.car"
					>
					</fa-icon>
				</b-col>
				<b-col
					sm="6"
				>
					
					<b-collapse 
						v-model="collapse.car" 
						id="collapse-car" 
						class="mt-2"
					>
						<b-form>
						  <b-form-group
							id="input-group-41"
							label="Марка автомобиля:"
							label-for="input-41"
							:invalid-feedback="errors.brand?errors.brand:''"
						  >
							<b-form-input
							  id="input-41"
							  v-model="car.brand"
							  required
							  :state="validCar"
							  placeholder="Марка автомобиля"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-42" 
							label="Модель автомобиля:" 
							label-for="input-42"
							:invalid-feedback="errors.model?errors.model:''"
						  >
							<b-form-input
							  id="input-42"
							  v-model="car.model"
							  required
							  :state="validCar"
							  placeholder="Модель автомобиля"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-43" 
							label="Год автомобиля:" 
							label-for="input-43"
							:invalid-feedback="errors.year?errors.year:''"
						  >
							<b-form-input
							  id="input-43"
							  v-model="car.year"
							  required
							  :state="validCar"
							  placeholder="гггг"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-45" 
							label="Цвет автомобиля:" 
							label-for="input-45"
							:invalid-feedback="errors.color?errors.color:''"
						  >
							<b-form-input
							  id="input-45"
							  v-model="car.color"
							  required
							  :state="validCar"
							  placeholder="Цвет автомобиля"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-46" 
							label="Регистрационный знак ТС:" 
							label-for="input-46"
							:invalid-feedback="errors.registration?errors.registration:''"
						  >
							<b-form-input
							  id="input-46"
							  v-model="car.registration"
							  required
							  :state="validCar"
							  placeholder="Регистрационный знак ТС"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-47" 
							label="VIN:" 
							label-for="input-47"
							:invalid-feedback="errors.vin?errors.vin:''"
						  >
							<b-form-input
							  id="input-47"
							  v-model="car.vin"
							  required
							  :state="validCar"
							  placeholder="VIN"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-48" 
							label="Номер свидетельства ТС:" 
							label-for="input-48"
							:invalid-feedback="errors.sts?errors.sts:''"
						  >
							<b-form-input
							  id="input-48"
							  v-model="car.sts"
							  required
							  :state="validCar"
							  placeholder="Номер свидетельства ТС"
							></b-form-input>
						  </b-form-group>
						  <b-form-group 
							id="input-group-49" 
							label="Номер лицензии:" 
							label-for="input-49"
							:invalid-feedback="errors.license?errors.license:''"
						  >
							<b-form-input
							  id="input-49"
							  v-model="car.color"
							  required
							  :state="validCar"
							  placeholder="Номер лицензии"
							></b-form-input>
						  </b-form-group>
						</b-form>
						<b-col class="d-flex justify-content-center">
							<b-button 
								size="sm"
								variant="dark"
								class="text-center"
								@click.prevent="saveCarHandler"
							>
								Сохранить
							</b-button>
						</b-col>
					</b-collapse>
				</b-col>
				
			</b-row>
		</div>
	</b-container>
</div>
</template>
<script>
import {mapActions, mapState, mapGetters} from 'vuex';
export default{
	name: 'personal',
	components: {},
	props: [
	],
	data: () => ({
		collapse: {
			general: true,
			passport: false,
			license: false,
			car: true
		},
		profile: {
			firstname: '',
			secondname: '',
			lastname: '',
			birthdate: '',
			phone: '',
			passport_series: '',
			passport_number: '',
			passport_giver: '',
			passport_date: '',
			registration_address: '',
			license_series: '',
			license_number: '',
			license_date: '',
			license_expire: ''
		},
		car: {
			brand: '',
			model: '',
			vin: '',
			sts: '',
			registration: '',
			year: '',
			color: '',
			license: '',
		},
		errors: {},
		validCar: null,
		validProfile: null
	}),
	computed: {
		...mapState(['user']),
		...mapGetters([])
	},
	methods: {
		...mapActions(['createProfile', 'createCar']),
		generalGoHandler(){
			this.collapse.general = false;
			this.collapse.passport = true;
		},
		passportGoHandler(){
			this.collapse.general = false;
			this.collapse.passport = false;
			this.collapse.license = true;
			
		},
		saveProfileHandler(){
			this.profile.user_id = this.user.id;
			this.createProfile(this.profile)
				.then(
					() => {
						this.validProfile= true;
						this.errors = {};
					}
				).catch(
					(e) => {
						console.log(e)
						/*
						if(!e.success){
							let obj = {};
							let errors = e.data.forEach(
								(error, i) =>{
									obj[error.field] = error.message;
								}
							);
							this.errors = errors;
							this.validProfile= false;
						}else{
							window.alert(`Что-то пошло не так ${e.response}`);
						}
						*/
					}
				)
		},
		saveCarHandler(){
			// Я закончил тут
			this.car.id_users = this.user.id;
			this.createCar(this.car)
				.then(
					() => {
						this.validCar = true;
						this.errors = {};
					}
				).catch(
					(e) => {
						if(!e.success){
							for(let error of e.data){
								this.errors[error.field] = error.message;
							}
							this.validCar = false;
						}else{
							window.alert(`Что-то пошло не так ${e.response}`);
						}
					}
				)
		},
		proccesErrors(errors){
			for(let error of e.data){
				this.errors[error.field] = error.message;
			}
		}
	},
	mounted(){
	}
}
</script>
<style scoped lang="sass">
	.personal
		&_top
			height: 34px
			background-color: #0A0B0B
			&_heading
				font-weight: 500
				font-size: 12px
				line-height: 20px
				color: #FFF
				margin-left: 20px
				padding-top: 7px
		&_heading
			font-weight: bold
			font-size: 18px
			line-height: 23px
			text-align: center
		&_general
			&__heading
				font-weight: 500
				font-size: 14px
				line-height: 18px
</style>