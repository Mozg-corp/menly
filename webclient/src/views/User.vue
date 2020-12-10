<template>
	<b-container class="pt-4">
		<b-row
			v-if="loadingUser"
			align-h="center"
		>
			<b-spinner
				variant="dark"
				type="grow"
			  ></b-spinner>
		</b-row>
		<b-row
			v-else-if="!loadingUser"
		>
			<b-col lg="12">
				<h2 class="user_header mb-4 mt-4">
					{{singleUser.phone}} {{singleUser.profile&&singleUser.profile.fio}}
				</h2>
				<p>
					Изменить статус: 
					<select 
						@change="changeUserStatusHandler($event)"
						class="ml-2"
					>
						<option v-for="status in statuses" :selected="status === statuses[singleUser.status]">
							{{status}}
						</option>
					</select>
				</p>
			</b-col>
			<b-col 
				sm="6" md="12"
				class=" register_agregator_box pt-3"
				v-if="singleUser.agregators&&singleUser.agregators.length&&singleUser.agregators.length!==singleUser.driverAccounts.length"			
			>
				<p>
					Список агрегаторов для регистрации
				</p>
				<div 
					
					v-for="agregator in singleUser.agregators"
					:key="agregator.id"
				>
					<div
						v-if="!driverAccountFilledIn(agregator)"
					>
						{{agregator.name}}
						<input 
							type="text"
							v-model="driverAccounts[agregator.name]"
							clss="ml-1"
						/>
						<input
							type="button"
							@click.prevent="createDriverAccountHandler($event, agregator)"
							value="Сохранить"
							class="ml-1"
						/>
					</div>
				</div>
				</p>
			</b-col>
			<b-col
				sm="6" md="12"
				v-else-if="singleUser.agregators&&!singleUser.agregators.length"	
				class=" register_agregator_box pt-3"				
			>
				<p>
					Пользователем не выбрано ни одного агрегатора
				</p>
			</b-col>
			<b-col 
				sm="6" md="12"
				class="pt-3"
			>
				<p>
					Список подключенных агрегаторов
				</p>
				<ul 
					v-if="singleUser.driverAccounts&&singleUser.driverAccounts.length"
				>
					<li
						v-for="account in singleUser.driverAccounts"
						:key="account.agregator.id"
					>
						<span class="account_name mr-4">{{account.agregator.name}}</span> 
						<span
							
						>{{account.account}}</span>
					</li>
				</ul>
				<p
					v-else
				>
					Пусто
				</p>
			</b-col>
		</b-row>
	</b-container>
</template>
<script>
import {mapActions, mapState, mapGetters} from 'vuex';
export default{
	name: 'user',
	props: ['id'],
	components: {},
	data: ()=>({
		driverAccounts: {},
		statuses: [
			'Not Active',
			'Candidate',
			'User'
		],
		selectedFilterStatus: 'Все',
	}),
	computed: {
		...mapState([
			'loadingUser',
			'singleUser',
		]),
	},
	methods: {
		...mapActions([
			'fetchSingleUser',
			'createDriverAccount',
			'changeUserState'
		]),
		driverAccountFilledIn(agregator){
			let index = this.singleUser.driverAccounts.findIndex(
				(driverAccount) => {
					if(driverAccount.agregator.id === agregator.id){
						return true;
					}else{
						return false;
					}

				}
			);
			return index === -1? false:true;
		},
		createDriverAccountHandler($event, agregator){
			let id_users = this.singleUser.id;
			let {id:id_agregator, name} = agregator;
			let id_account_types = 1;
			let account = this.driverAccounts[name];
			let driverAccount = {
				id_users,
				id_agregator,
				id_account_types,
				account
			};
			this.createDriverAccount(driverAccount)
				.then(
					() => {
						this.fetchSingleUser(this.id)
					}
				)
		},
		changeUserStatusHandler($event){
			let statusName = $event.target.value;
			let status = this.statuses.findIndex( el => el === statusName)
			let userId = this.singleUser.id;
			this.changeUserState({userId, status});
		}
	},
	mounted(){},
	created(){
		if(this.id){
			this.fetchSingleUser(this.id)
		}
	}
}
</script>
<style scoped lang="sass">
	.user_header
		font-size: 16px
	.account_name
	.register_agregator_box
		border: 1px solid black
		background-color: lightgrey
</style>