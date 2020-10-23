<template>
	<div v-if="loading" class="profile_container r-flex">
			Loading...
	</div>
	<div v-else id="meters" class="profile_container__main meters">
		<h2 class="cabinet_header">
			{{singleMeter.typeDescription}} {{singleMeter.model}} - С\Н: {{ singleMeter.serialNumber}}
		</h2>
		<h3 class="sub_header">
			№ лицевого счета {{singleMeter.accountId}}
		</h3>
		<div class="meters_box">
			<div class="meters_box__item">
				<div class="meter_item__col">
					<p>
						Тип
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Тарифы
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Серийный номер
					</p>
				</div>
			</div><!--meter_box_item-->
			<div class="meters_box__item">
				<div class="meter_item__col">
					<p>
						{{singleMeter.typeDescription}} 
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						{{singleMeter.tariffDescription}} 
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						{{ singleMeter.serialNumber}}
					</p>
				</div>
			</div><!--meter_box_item-->
			<div class="meters_box__item">
				<div class="meter_item__col">
					<p>
						Модель
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Дата поверки
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						
					</p>
				</div>
			</div><!--meter_box_item-->
			<div class="meters_box__item">
				<div class="meter_item__col">
					<p>
						{{singleMeter.model}}
					</p>
				</div>
				<div class="meter_item__col">
					<p>
					{{singleMeter.checkDate}}
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						
					</p>
				</div>
			</div><!--meter_box_item-->
		</div><!--meter_box-->
		<div class="controls_container">
			<a href="#" class="editMeter" @click.prevent="showModal=!showModal">
				Внести изменения
			</a>
			<a href="#" class="deleteMeter">
				Удалить счетчик
			</a>
		</div>
		<div class="history_box">
			<h3>
				История показаний:
			</h3>
			<div class="history_tbl">
				<div class="history_tbl_row" v-for="indication in singleMeterAllIndications" :key="indication.id">
					<div class="history_tbl_cell">
						<p>
							{{indication.creationDate}}
						</p>
					</div>
					<div class="history_tbl_cell">
						<p>
							{{indication.value}}
						</p>
					</div>
				</div>
			</div>
		</div>
		<div id="" :class="[modal, showModal? login_show : '']" >
				<div id="updateCounter" class="r-flex">
					<p id="close_modal" class="modal_close">
						<a href="#" class="close_X" id="close_X" @click.prevent="showModal=!showModal">
							X
						</a>
					</p>
					<h2>
						Редактировать счётчик
					</h2>
					<form name="updateCounter"  action="#" method="post" class="r-flex">
						<div class="r-flex">
							<label for="account">
								<b>
									№ лицевого счета
								</b>
							</label>
							<input type="text" name="account" v-model="updateCounter.accountId"/>
						</div>
						<div class="r-flex">
							<label for="typeDescription">
								<b>
									Тип
								</b>
							</label>
							<input type="text" name="typeDescription" v-model="updateCounter.typeDescription"/>
						</div>
						
						<div class="r-flex">
							<label for="serialNumber">
								<b>
									Серийный номер
								</b>
							</label>
							<input type="text" name="serialNumber" v-model="updateCounter.serialNumber"/>
						</div>
						<div class="r-flex">
							<label for="model">
								<b>
									Модель
								</b>
							</label>
							<input type="text" name="model" v-model="updateCounter.model"/>
						</div>
						<div class="r-flex">
							<label for="checkDate">
								<b>
									Дата поверки
								</b>
							</label>
							<input type="text" name="checkDate" v-model="updateCounter.checkDate"/>
						</div>
						<div class="r-flex">
							<label for="tariffDescription">
								<b>
									Тарифы
								</b>
							</label>
							<input type="text" name="tariffDescription" v-model="updateCounter.tariffDescription"/>
						</div>
						
						
						<div class="login_controls r-flex">
							<input type="submit" name="submit" value="Обновить" @click.prevent="updateCounterHandler"></input>
							<input type="button" name="cancel" value="отмена" @click.prevent="updateCancelHandler"></input>
						</div>
					</form>
				</div>
			</div>
	</div>
</template>
<script>
	import {mapActions, mapState} from 'vuex';
	export default{
		name: 'SingleMeter',
		props: ['id'],
		components: {
		},
		data: ()=>({
			loading: false,
			updateCounter: {
				accountId: '',
				serialNumber: '',
				model: '',
				typeDescription: '',
				checkDate: '',
				tariffDescription: ''
			} ,
			showModal: false,
			modal: 'modal',
			login_show: 'login_active',
		}),
		computed: {
			...mapState(['singleMeter', 'singleMeterAllIndications'])
		},
		methods: {
			updateCounterHandler(){
				this.updateCounterDescription(this.updateCounter)
					.then(
						counter => {
							this.updateCounter = {...counter};
							this.showModal = ! this.showModal;
						}
					)
			},
			updateCancelHandler(){
				this.updateCounter = {...this.singleMeter};
				this.showModal=!this.showModal;
			},
			...mapActions(['fetchSingleMeter', 'fetchAllSingleMeterIndications', 'updateCounterDescription'])
		},
		mounted(){
			this.loading = true;
			this.fetchSingleMeter(this.id)
				.then(
					meter => {
						this.loading = false;
						this.updateCounter = {...meter};
					}
				)
			this.fetchAllSingleMeterIndications(this.id)
				.then(
					ind => console.log(ind)
				)
			
		}
	}
</script>
<style lang="sass">
	form[name="updateCounter"] 
		flex-direction: column
		justify-content: space-around
		padding: 40px 40px 20px 40px
		font-style: normal
		font-weight: normal
		font-size: 18px
		line-height: 22px
		text-align: center
		color: #404040
		height: 100%
	form[name="updateCounter"] input
		margin: 5px
		width: 60%
		padding: 8px 7px
		background-color: #F4F4F4
		box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.25)
		border-radius: 5px
		border-color: #F4F4F4
	#updateCounter
		width: 50%
		height: 40%
	.login_active
		display: block
		pointer-events: auto
	.meters
		width: 100%
	.cabinet_header
		width: 100%
	.meters_box
		display: table
		width: 100%
		font-size: 18px
		line-height: 22px
		color: #000000
	.meters_box__item
		display: table-row
	.meter_item__col
		display: table-cell
		padding: 10px
	.sub_header
		margin: 20px 0 20px 0
	.editMeter,
	.deleteMeter
		font-weight: 600
		font-size: 22px
		line-height: 27px
		text-align: center
		color: #000000
		padding: 5px 40px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background-color: #A1DC92
		border-radius: 10px
	.deleteMeter
		background-color: #EF3630
		margin-left: 50px
	.controls_container
		margin: 50px auto 0 auto
		width: 100%
		text-align: center
	.history_box
		margin: 40px 0
	.history_tbl
		display: table
		min-width: 200px
		margin: 20px 0
	.history_tbl_row
		display: table-row
		margin: 15px 0
	.history_tbl_cell
		display: table-cell
</style>