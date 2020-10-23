<template>
	<main >
		<div class="container_my content">
			<div v-if="user.agregators && !user.agregators.length">
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
			<div v-else>
				<ul>
					<li v-for="(agregator, i) in user.agregators" :key="agregator.id">
							{{agregator.name}}
					</li>
				</ul>
			</div>
			<div class="passport_box">
				<p>
					Заполнение профиля водителя
				</p>
				<input type="text" name="firstname" v-model="profile.firstname" placeholder="firstname"/>
				<input type="text" name="secondname" v-model="profile.secondname" placeholder="secondname"/>
				<input type="text" name="lastname" v-model="profile.lastname" placeholder="lastname"/>
				<input type="text" name="phone" v-model="profile.phone" placeholder="phone"/>
				<input type="text" name="passport_series" v-model="profile.passport_series" placeholder="passport_series"/>
				<input type="text" name="passport_number" v-model="profile.passport_number" placeholder="passport_number"/>
				<input type="text" name="passport_giver" v-model="profile.passport_giver" placeholder="passport_giver"/>
				<input type="text" name="passport_date" v-model="profile.passport_date" placeholder="passport_date"/>
				<input type="text" name="registration_address" v-model="profile.registration_address" placeholder="registration_address"/>
				<input type="text" name="license_series" v-model="profile.license_series" placeholder="license_series"/>
				<input type="text" name="license_number" v-model="profile.license_number" placeholder="license_number"/>
				<input type="text" name="license_date" v-model="profile.license_date" placeholder="license_date"/>
				<input type="text" name="license_expire" v-model="profile.license_expire" placeholder="license_expire"/>
			</div>
			
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
	}
  }),
  components: {
  },
  computed: {
	...mapState(['agregators_list', 'user'])
  },
  methods:{
	...mapActions(['postAgregators']),
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
</styles>