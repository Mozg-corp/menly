<template>
	<div v-if="loading" class="profile_container">
			Loading...
	</div>
	<div v-else id="meters" class="profile_container__main meters">
		<h2 class="cabinet_header">
			Счетчики
		</h2>
		<h3 class="sub_header">
			Передача показаний приборов учета электроэнергии:
		</h3>
		<div class="meters_box r-flex">
			<div class="meters_box__item r-flex thead">
				<div class="meter_item__col">
					<p>
						№ участка:
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						№ лицевого счета:
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Серийный № счетчика:
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Тип счетчика:
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Последние показания:
					</p>
				</div>
				<div class="meter_item__col">
					<p>
						Ввести текущие показания:
					</p>
				</div>
			</div><!--meter_box_item-->
			<MeterItem v-for="meter in meters" :key="meter.id" :meter="meter"/>
		</div><!--meter_box-->
		<div class="controls_container">
			<a href="#" class="saveMeterIndication_btn" @click.prevent="saveBtnHandler">
				Сохранить показания
			</a>
			<a href="#" class="addNewMeter" @click.prevent="showModal=!showModal">
				Добавить новый счётчик
			</a>
		</div>
		<div id="" :class="[modal, showModal? login_show : '']" >
				<div id="addNewCounter" class="r-flex">
					<p id="close_modal" class="modal_close">
						<a href="#" class="close_X" id="close_X" @click.prevent="showModal=!showModal">
							X
						</a>
					</p>
					<h2>
						Добавить новый счётчик
					</h2>
					<form name="addNewCounter"  action="#" method="post" class="r-flex">
						<div class="r-flex">
							<label for="account">
								<b>
									№ лицевого счета
								</b>
							</label>
							<input type="text" name="account" v-model="newCounter.accountId"/>
						</div>
						<div class="r-flex">
							<label for="typeDescription">
								<b>
									Тип
								</b>
							</label>
							<input type="text" name="typeDescription" v-model="newCounter.typeDescription"/>
						</div>
						
						<div class="r-flex">
							<label for="serialNumber">
								<b>
									Серийный номер
								</b>
							</label>
							<input type="text" name="serialNumber" v-model="newCounter.serialNumber"/>
						</div>
						<div class="r-flex">
							<label for="model">
								<b>
									Модель
								</b>
							</label>
							<input type="text" name="model" v-model="newCounter.model"/>
						</div>
						<div class="r-flex">
							<label for="checkDate">
								<b>
									Дата поверки
								</b>
							</label>
							<input type="text" name="checkDate" v-model="newCounter.checkDate"/>
						</div>
						<div class="r-flex">
							<label for="tariffDescription">
								<b>
									Тарифы
								</b>
							</label>
							<input type="text" name="tariffDescription" v-model="newCounter.tariffDescription"/>
						</div>
						
						
						<div class="login_controls r-flex">
							<input type="submit" name="submit" value="Создать" @click.prevent="createNewCounterHandler"></input>
							<input type="button" name="cancel" value="отмена" @click.prevent="showModal=!showModal"></input>
						</div>
					</form>
				</div>
			</div>
	</div>
</template>
<script>
	import {mapActions, mapState} from 'vuex';
	import MeterItem from '@/components/MeterItem';
	export default{
		name: 'meters',
		components: {
			MeterItem
		},
		data: ()=>({
			loading: false,
			showModal: false,
			modal: 'modal',
			login_show: 'login_active',
			newCounter: {
				accountId: '',
				serialNumber: '',
				model: '',
				typeDescription: '',
				checkDate: '',
				tariffDescription: ''
			} 
		}),
		computed: {
			...mapState(['meters'])
		},
		methods: {
			saveBtnHandler(){
				//console.log(this.$children)
				//let i = this.$children.values()
				//for(i.next();i.done;i.next())	console.log(el)
				let metersData = [];
				for(let el of this.$children){
					if(el.value !== '' && el.value !== null){
						metersData.push({
							value: +el.value,
							meterId: el.meter.meterId
						})
						el.value = '';
					}
				}
				//console.log(metersData)
				this.updateMetersBatch(metersData);
				
				
			},
			createNewCounterHandler(){
			this.newCounter.accountId = +this.newCounter.accountId
			console.log(this.newCounter)
				this.createNewCounter(this.newCounter)
					.then(
						newCounter => this.showModal = false
					)
			},
			...mapActions(['fetchAllMeters', 'updateMetersBatch', 'createNewCounter'])
		},
		mounted(){
			this.loading = true;
			this.fetchAllMeters()
					.then(
						meters => {
							this.loading = false;
							console.log(meters)
						}
					)
			//console.log(this.$children.values())
		}
	}
</script>
<style lang="sass">
	form[name="addNewCounter"] 
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
	form[name="addNewCounter"] input
		margin: 5px
		width: 60%
		padding: 8px 7px
		background-color: #F4F4F4
		box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.25)
		border-radius: 5px
		border-color: #F4F4F4
	#addNewCounter
		width: 50%
		height: 40%
	.meters
		width: 100%
	.cabinet_header
		width: 100%
	.meters_box
		/*flex-direction: column*/
		display: table
		font-size: 18px
		line-height: 22px
		color: #000000
		justify-content: space-beetween
	.meters_box__item
		/*flex-wrap: nowrap*/
		display: table-row
		margin: 8px 0
	.meter_item__col
		display: table-cell
		padding: 3px 0
	.meter_item__col1
		flex-grow: 1
		flex-basis: 150px
		display: table-cell
	.meter_item__col2
		flex-grow: 1
		flex-basis: 100px
		display: table-cell
	.meter_item__col3
		flex-grow: 9
		flex-basis: 0
		display: table-cell
	.meter_item__col4
		flex-grow: 1
		font-size: 18px
		line-height: 22px
		color: #000000
		display: table-cell
	.meter_item__col5
		flex-grow: 1
		font-size: 18px
		line-height: 22px
		color: #000000
		display: table-cell
	.meter_item__col6
		flex-grow: 1
		font-size: 18px
		line-height: 22px
		color: #000000
		display: table-cell
	.mg-l40
		margin-left: 40px
	.thead
		display: table-header-group 
		margin: 0 0 30px 0
	.saveMeterIndication_btn,
	.addNewMeter
		font-weight: 600
		font-size: 22px
		line-height: 27px
		text-align: center
		color: #000000
		padding: 5px 40px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background-color: #A1DC92
		border-radius: 10px
	.addNewMeter
		background-color: #A99
		margin-left: 50px
	.sub_header
		margin: 20px 0 30px 0
	.controls_container
		margin: 150px auto 0 auto
		width: 100%
		text-align: center
	.login_active
		display: block
		pointer-events: auto
</style>