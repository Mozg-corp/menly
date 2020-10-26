<template>
	<main >
		<div class="container_my content">
			<div v-show="isAuthenticated" class="main_box">
				<div class="left_side">
					<div v-if="user.agregators && !user.agregators.length">
						Выберите агрегаторов подключать
						<ul @click="toggleLi($event)">
							<li v-for="(agregator, i) 
								in agregators_list" 
								:key="agregator.id"
								:data-id="agregator.id"
								>
									{{agregator.name}}
							</li>
						</ul>
						<a class="choose" href="#" @click.prevent="chooseAgregatorsHandler">
							Выбрать
						</a>
					</div>
					<div v-else style="border:1px solid black">
						<h2 style="margin-bottom: 30px">
							Вы подключены к
						</h2>
						<ul >
							<li v-for="(agregator, i) in user.agregators" :key="agregator.id">
									{{agregator.name}}
							</li>
						</ul>
					</div>
					<div v-if="!user.profile" class="passport_box">
						<p>
							Заполнение профиля водителя
						</p>
						<input type="text" name="firstname" v-model="profile.firstname" placeholder="firstname"/>
						<input type="text" name="secondname" v-model="profile.secondname" placeholder="secondname"/>
						<input type="text" name="lastname" v-model="profile.lastname" placeholder="lastname"/>
						<input type="text" name="birthdate" v-model="profile.birthdate" placeholder="birthdate dd.mm.yyyy"/>
						<input type="text" name="phone" v-model="profile.phone" placeholder="phone"/>
						<input type="text" name="passport_series" v-model="profile.passport_series" placeholder="passport_series"/>
						<input type="text" name="passport_number" v-model="profile.passport_number" placeholder="passport_number"/>
						<input type="text" name="passport_giver" v-model="profile.passport_giver" placeholder="passport_giver"/>
						<input type="text" name="passport_date" v-model="profile.passport_date" placeholder="passport_date dd.mm.yyyy"/>
						<input type="text" name="registration_address" v-model="profile.registration_address" placeholder="registration_address"/>
						<input type="text" name="license_series" v-model="profile.license_series" placeholder="license_series"/>
						<input type="text" name="license_number" v-model="profile.license_number" placeholder="license_number"/>
						<input type="text" name="license_date" v-model="profile.license_date" placeholder="license_date dd.mm.yyyy"/>
						<input type="text" name="license_expire" v-model="profile.license_expire" placeholder="license_expire dd.mm.yyyy"/>
						<a href="#" @click.prevent="sendProfileHandler" class="send_profile">
							Отправить
						</a>
					</div>
					<div v-else class="passport_box" style="border:1px solid black">
						<h2 style="margin-bottom: 30px">
							Профиль водителя
						</h2>
						<ul >
							<li v-for="(property, i) in user.profile" :key="i" class="property">
								{{property}}
							</li>
						</ul>
					</div>
					<div v-if="!user.car" class="passport_box">
						<p>
							Заполнение данных о машине
						</p>
						<input type="text" name="brand" v-model="car.brand" placeholder="brand"/>
						<input type="text" name="model" v-model="car.model" placeholder="model"/>
						<input type="text" name="vin" v-model="car.vin" placeholder="vin"/>
						<input type="text" name="sts" v-model="car.sts" placeholder="sts"/>
						<input type="text" name="registration" v-model="car.registration" placeholder="registration"/>
						<input type="text" name="year" v-model="car.year" placeholder="year"/>
						<input type="text" name="color" v-model="car.color" placeholder="color"/>
						<input type="text" name="license" v-model="car.license" placeholder="license"/>
						<a href="#" @click.prevent="sendCarHandler" class="send_profile">
							Отправить
						</a>
					</div>
					<div v-else class="passport_box">
						<p v-for="(property, i) in user.car" :key="i" class="property">
							{{property}}
						</p>
					</div>
				</div> <!--left_side-->
				<div class="right_side">
					<h2>
						Ваш баланс
					</h2>
					<div v-for="agregator in user.agregators" class="balance_row" >
						<p>
							{{agregator.name}}
						</p>
						<p>
							{{balances[agregator.name]}}
						</p>
					</div>
					<div class="balance_row">
						<p>
							<b>Summ</b>
						</p>
						<p>
							{{summ}}
						</p>
					</div>
				</div> <!--right_side-->
			</div><!--main_box-->
		</div><!--container-->
	</main> <!--main-->
</template>

<script>
// @ is an alias to /src
import {mapGetters, mapActions, mapState} from 'vuex';
export default {
  name: 'home',
  data: ()=> ({
	selectedAgregators: [],
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
	}
  }),
  components: {
  },
  computed: {
	...mapState(['agregators_list', 'user', 'balances']),
	...mapGetters(['isAuthenticated']),
	summ(){
		let summ = 0;
		let b = JSON.parse(JSON.stringify(this.balances))
		//**/
		if(b){
			for(let el of Object.values(b)){
				summ += +el
			}
			return summ
		}
		//*/
	}
  },
  methods:{
	...mapActions(['postAgregators', 'createProfile', 'createCar', 'fetchBalances']),
	chooseAgregatorsHandler(){
		this.postAgregators(this.selectedAgregators)
	},
	toggleLi($event){
		let id = $event.target.dataset.id;
		if(this.selectedAgregators.includes(id)){
			let index = this.selectedAgregators.findIndex(el => el === id);
			console.log(this.selectedAgregators.slice(0, index));
			console.log(this.selectedAgregators.slice(index+1));
			this.selectedAgregators = [...this.selectedAgregators.slice(0, index), ...this.selectedAgregators.slice(index + 1)]
		}else{
			this.selectedAgregators.push(id)
		}
	},
	sendProfileHandler(){
		this.profile.user_id = this.user.id;
		this.createProfile(this.profile)
	},
	sendCarHandler(){
		this.car.id_users = this.user.id;
		this.createCar(this.car)
	}
  },
  
  mounted(){
		
  }
}
</script>
<styles scoped lang="sass">
	ul
		list-style-type: none
	.choose
		padding: 5px 30px
		background-color: #cbd3d6
	.passport_box
		max-width: 200px
		display: flex
		flex-direction: column
		justify-content: space-beetween
		margin: 30px 0
	input
		padding: 5px 10px
		margin: 5px 0
	.send_profile
		padding: 5px 30px
		background-color: #cbd3d6
	.property
		margin: 5px 0
	.main_box
		display: flex
		justify-content: space-between
	.right_side
		width: 50%
	.balance_row
		display: flex
		justify-content: space-between
		margin: 0 auto
		width: 100%
		border-bottom: 1px solid black
		margin: 5px 0
</styles>