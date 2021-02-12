<template>
<div>
	<div class="home_top">
		<b-container>
			<h2 class="home_top_heading">
				Кабинет
			</h2>
		</b-container>
	</div>
	<div>
		<b-container class="text-center pt-2">
			<b-row>
				<b-col class="pt-3">
					<div class="banner_founds">
						<h4 class="banner_founds__header">
							На балансе
						</h4>
						<h2 v-if="loadingBalances">
							<b> --.-- ₽</b> 
						</h2>
						<h2 v-else
							class="banner_found__content">
							{{totalBalance | fix2Number}} ₽
						</h2>
					</div>
				</b-col>
			</b-row>
			<b-row v-if="loadingBalances" align-h="center" class="pt-4">
				<b-spinner
					variant="dark"
					type="grow"
				  ></b-spinner>
			</b-row>
			<div v-else>
				<div v-if="done" class="transfer_done align-items-center text-center">
					<p>
						Перевод успешно создан
					</p>
				</div>
				<b-row v-else align-h="center" class="pt-3">
					<b-col>
						<h5
							v-if="hasProccessingTransfers"
							class="banner_founds__orders mb-3"
						>
							Переводы в процессе обработки (дождитесь их завершения)
						</h5>
						<div v-if="hasProccessingTransfers"
							class="table_trandfers"
						>
							<div class="row_transfers"
								v-for="transfer in proccessingItems"
							>
								<div class="cell_transfers">
									{{transfer.date}}
								</div>
								<div class="cell_transfers">
									<img 
										:src="`./img/agregators/logoes/sm/${transfer.logo}`" 
										alt="Логитип агрегатора"
										class="logo_img"
									/>
								</div>
								<div class="cell_transfers">
									<b>{{transfer.transfer}}</b>
								</div>
							</div>
						</div>
					</b-col>
					<b-col sm="12" 
						v-for="[name, balance] in Object.entries(balances)" 
						:key="name"
						class="pb-2"
					>
						<div 
							v-if="!hasAgregatorsTransfers(name)"
							class="agregator_transfer d-flex justify-content-center"
						>
							<div class="agregator_box d-flex align-items-center justify-content-around">
								<div class="agregator_box__left">
									<p class="agregator_name">
										{{name}}
									</p>
									<p class="agregator_balance">
										{{balance | fix2Number}} ₽
									</p>
								</div>
								<b-form class="agregator_box_right">
									<b-form-group 
									:id="name" 
									:label-for="'input-'+name"
									@submit.prevent="transferHandler"
								  >
									<b-form-input
									  id="input-49"
									  v-model="createTransfers[name]"
									  required
									  type="number"
									></b-form-input>
								  </b-form-group>
								</b-form>
							</div>
						</div>
						<div
							v-else
						>
							У вас уже есть не завершённый перевод у {{name}}. Дождитесь его завершения.
						</div>
					</b-col>
					<b-col sm="12" class="d-flex justify-content-center pt-4">
						<b-button 
							size="sm"
							variant="dark"
							class="text-center"
							@click.prevent="transferHandler"
						>
							Вывести деньги
						</b-button>
					</b-col>
				</b-row>
			</div>
			<b-row class="pt-5">
				<b-col>
					<h5 class="banner_founds__orders mb-3">
							История переводов
					</h5>
					<b-spinner
						v-if="loadingTransfers"
						variant="dark"
						type="grow"
					  ></b-spinner>
					<div v-else
						class="table_trandfers"
					>
						<p v-show="transferedItems.length===0">
							У вас пока нет переводов
						</p>
						<div class="row_transfers"
							v-for="transfer in transferedItems"
						>
							<div class="cell_transfers">
								{{transfer.date}}
							</div>
							<div class="cell_transfers">
								<img 
									:src="`./img/agregators/logoes/sm/${transfer.logo}`" 
									alt="Логитип агрегатора"
									class="logo_img"
								/>
							</div>
							<div class="cell_transfers">
								<b>{{transfer.transfer}}</b>
							</div>
						</div>
					</div>
				</b-col>
			</b-row>
		</b-container>
	</div>
</div>
</template>

<script>
// @ is an alias to /src
import {mapGetters, mapActions, mapState, mapMutations} from 'vuex';
export default {
  name: 'home',
  data: ()=> ({
	createTransfers: {},
	errors: {
		
	},
	done: false
  }),
  components: {
  },
  filters: {
	  fix2Number: function (value) {
		return parseFloat(value).toFixed(2);
	  }
	},
  computed: {
	...mapState([
		'loadingUserData', 
		'loadingBalances', 
		'balances', 
		'agregators_list',
		'transfers',
		'userId',
		'loadingTransfers'
	]),
	...mapGetters([]),
	totalBalance(){
		let allBalances = this.balances;
		let sum = 0.0;
		for(let agregator in allBalances){
			sum += parseFloat(allBalances[agregator]);
		}
		return sum;
	},
	items(){
		return this.transfers.map(
			(transfer) => {
				let agregator = this.agregators_list.filter((agregator) =>{
					return agregator.name === transfer.agregators.name
				});
				return {
					date: (new Date(transfer.created_at)).toLocaleDateString(),
					logo: agregator[0].logo,
					transfer: transfer.transfer,
					status: transfer.transferStatuses.status
				}
			}
		);
	},
	transferedItems(){
		//return this.items;
		return this.items.filter(transfer=>transfer.status === 'Переведено');
	},
	proccessingItems(){
		return this.items.filter(transfer=>transfer.status === 'Создан' || transfer.status === 'Списано');
	},
	hasProccessingTransfers(){
		return this.proccessingItems.length > 0;
	}
  },
  methods:{
	...mapMutations([]),
	...mapActions([
		'fetchUserTransfers',
		'fetchAgregatorsList',
		'fetchBalances',
		'postTransfers'
	]),
	transferHandler(){
		let transfers = [];
		for(let agregatorName in this.createTransfers){
			let transfer = parseFloat(this.createTransfers[agregatorName])
			
			if(transfer !== '' && transfer > 0){
				transfer = '-' + transfer;
				transfers.push(
					{
						agregatorName,
						transfer
					}
				);
			}
		}
		this.postTransfers(transfers)
			.then(
				()=>{
					this.agregators_list.forEach(
						(agregator) => {
							this.createTransfers[agregator.name] = ''
						}
					);
					this.done = true;
					this.fetchUserTransfers();
				}
			);
	},
	hasAgregatorsTransfers(name){
		for(let i=0; i<this.transfers.length; i++){
			if(this.transfers[i].agregators.name === name 
				&& 
					(
						this.transfers[i].transferStatuses.status === 'Создан'
						||
						this.transfers[i].transferStatuses.status === 'Списано'
					)
			){
				return true;		
			}
		}
		return false;
	},
	validateTransfers(){
	
	}
  },
  
  mounted(){
  
  },
  created(){
	this.fetchAgregatorsList()
		.then(
			(agregatorsList) => {
				agregatorsList.forEach(
					(agregator) => {
						this.createTransfers[agregator.name] = ''
					}
				);
			}
		)
	this.fetchUserTransfers()
		.then(
			(transfers) => {
				//console.log(transfers)
			}
		).catch(
			(e) => {
				console.log(e);
			}
		);
  }
}
</script>
<styles scoped lang="sass">
	.home
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
	.banner_founds
		background-color: #01B6E7
		border-top-left-radius: 20px
		border-top-right-radius: 20px
		width: 100%
		min-height: 120px
		max-height: 150px
		color: #FFFFFF
		padding: 15px 0 0 0
		&__header
			font-weight: 500
			font-size: 14px
			line-height: 18px
			margin-bottom: 20px
		&__content
			font-weight: 500
			font-size: 36px
			line-height: 46px
	.table_trandfers
		display: table
		width: 100%
	.row_transfers
		display: table-row
		padding-bottom: 10px
	.cell_transfers
		display: table-cell
		padding: 3px 5px
	.logo
		border: 1px solid #02BAE8
		border-radius: 12px
		width: 32px
		min-height: 16px
		&_img
			display: inline-table
	.Списано
		color: orange
	.Создан	
		color: blue
	.Переведено
		color: green
	.Отклонено
		color: red
	.agregator_transfer
		border: 1px solid #01B6E7
		border-radius: 10px
	.agregator
		&_box
			padding: 4px
			font-weight: 500
			font-size: 14px
			line-height: 18px
			width: 100%
			&__left
				width: 50%
			&__right
				width: 50%
		&_balance
			color: #01B6E7
	.transfer_done
		width: 100%
		height: 50px
		background-color: orange
		color: blue
		font-size: 18px
		font-weight: 600
		margin: 20px 0 0 0
		display: flex
		&>p
			margin: 0 auto
		
</styles>