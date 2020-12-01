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
							Личные средства
						</h4>
						<h2 class="banner_found__content">
							{{totalBalance}}
						</h2>
					</div>
				</b-col>
			</b-row>
			<b-row class="pt-3">
				<b-col>
					<h5 class="banner_founds__orders mb-3">
							Ваши заявки
					</h5>
					<div class="table_trandfers">
						<div class="row_transfers"
							v-for="transfer in items"
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
							<div :class="[{cell_transfers: true}, transfer.status]">
								{{transfer.status}}
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
  }),
  components: {
  },
  computed: {
	...mapState([
		'loadingUserData', 
		'loadingBalances', 
		'balances', 
		'agregators_list',
		'transfers'
	]),
	...mapGetters([]),
	totalBalance(){
		let allBalances = this.balances;
		let sum = 0.0;
		for(let agregator in allBalances){
			sum += allBalances[agregator];
		}
		return parseFloat(sum).toFixed(2);
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
	transferStatus: function () {
		return {
		  created: this.claim.status === 'Направлено',
		  inwork: this.claim.status === 'В работе',
		  canceled: this.claim.status === 'Отменено',
		  done: this.claim.status === 'Выполнено',
		  recieved: this.claim.status === 'Получено'
		}
	}
  },
  methods:{
	...mapMutations([]),
	...mapActions([
		'fetchUserTransfers',
		'fetchAgregatorsList'
	])
  },
  
  mounted(){
  
  },
  created(){
	this.fetchAgregatorsList();
	this.fetchUserTransfers()
		.then(
			(transfers) => {
				/*this.transfers = transfers.map(
					(transfer) => {
						return {
							"Дата" => transfer.created_at,
							"Агрегатор" => transfer.agregators.name,
							"Сумма" => transfer.transfer,
							"Статус" => transfer.statuses.status
						}
					}
				);*/
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
</styles>