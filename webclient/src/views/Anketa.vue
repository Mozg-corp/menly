<template>
	<b-container class="pt-3">
		<div v-if="loadingUserData"
			class="spinner"
		>
			<b-spinner
				variant="dark"
				type="grow"
			></b-spinner>
		</div>
		<div v-else>
			<div v-if="!agregators_list_filledin">
				<h2 class="anketa_heading">
					Выбери агрегатор такси через который ты работаешь
				</h2>
				<b-row align-h="center">
					<b-col
						sm="6"
						class="text-center"
					>
						<div>
							<b-spinner
								v-if="!agregatorsListDownloaded"
								variant="dark"
								type="grow"
							  ></b-spinner>
							  <ul v-else>
								<li 
									class="anketa_li"
									v-for="(agregator, i) in getAgregatorsList"
									:key="i"
									@click="toggleAgregatorCheck(i)"
								>
									<b-icon icon="check-circle-fill" :variant="variants[i]"></b-icon>
									<b-img
										class="anketa_li__img anketa_li__img__gett"
										:src="'/img/anketa/' + agregator.logo" 
										fluid 
										:alt="agregator.name + ' агрегатор лого'"
									>
									</b-img>
								</li>
							  </ul>
						</div>
					</b-col>
					<b-col
						sm="12"
						class="text-center"
					>
						<b-button 
							size="lg"
							variant="dark"
							class="text-center"
							@click.prevent="postAgregatorsHandler"
						>
							Выбрать
						</b-button>
					</b-col>
				</b-row>
			 </div>
		</div>
	</b-container>
</template>
<script>
import {mapActions, mapState, mapGetters} from 'vuex';
export default{
	name: 'anketa',
	components: {},
	props: [
	],
	data: () => ({
		variants: [
					'secondary',
					'secondary',
					'secondary'
				]
	}),
	computed: {
		...mapState(['user', 'agregators_list', 'loadingUserData', 'userChooseAgregator']),
		...mapGetters(['userHasAgregators', 'getAgregatorsList']),
		agregators_list_filledin(){
			return this.userHasAgregators
		},
		agregatorsListDownloaded(){
			return this.getAgregatorsList.length > 0;
		}
	},
	methods: {
		...mapActions(['fetchAgregatorsList', 'postAgregators']),
		toggleAgregatorCheck(i){
			let newVariant = this.variants[i] === 'secondary'? 'dark':'secondary';
			this.variants = [
				...this.variants.slice(0, i),
				newVariant,
				...this.variants.slice(i+1)
			];
			
		},
		postAgregatorsHandler(){
			let checkedAgregators = this.getAgregatorsList.filter(
				(agregator, i) => {
					return this.variants[i] === 'dark';
				}
			);
			if(checkedAgregators.length){
				this.postAgregators(checkedAgregators)
					.then(
						() => {
							this.$router.push({name: 'personal'});
						}
					).catch(
						(e) => {
							if(e.data && e.data.message){
								windows.alert(e.data.message)
							}else{
								windows.alert('Что-то пошло не так, попробуйте повторить ещё чуть позже.');
							}
						}
					)
			}
		},
	},
	mounted(){
		
	},
	created(){
		this.fetchAgregatorsList();
		if(this.userChooseAgregator){
			this.$router.push({name: 'personal'})
		}
	}
}
</script>
<style scoped lang="sass">
	.anketa
		&_heading
			font-weight: bold
			font-size: 18px
			line-height: 23px
			text-align: center
			margin-bottom: 32px
		&_li
			text-align: left
			border: 1px solid #02BAE8
			border-radius: 24px
			padding: 1rem
			margin-bottom: 20px
			&__img
				height: 69px
				width: 145px
				margin: 5px auto 32px auto
				display: block
			&__img__gett
				height: 69px
				width: 145px
	.spinner
		text-align: center
</style>