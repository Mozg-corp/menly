<template>
	<div>
		<article class="member_meters r-flex">
				<h2>
					{{meter.typeDescription}}, {{meter.model}}  № {{meter.serialNumber}}
				</h2>
			</article>
			<form class="counter_box r-flex" method="post" action="#" name="electricity_form">
				<div class="previos_numbers r-flex">
					<p>
						Предыдущие показания от <br/> {{meter.currentMeterData.creationDate}}
					</p>
					<p>
						<b>{{meter.currentMeterData.value}}</b>
					</p>
				</div>
				<div class="current_numbers r-flex">
					<p>
						Текущие показания
					</p>
					<input type="text" name="electricity_value" :placeholder="meter.currentMeterData.value.toString()+' + N'" v-model="newValue"/>
				</div>
				<div>
					<input type="submit" name="send_electricity" value="Отправить" class="send_value" @click.prevent="sendIndicationHandler"/>
				</div>
			</form>
	</div>
</template>
<script>
import {mapActions} from 'vuex';
export default{
	name: 'CounterItemValue',
	props: [
		'meter'
	],
	data: ()=>({
		newValue: null
	}),
	methods: {
		sendIndicationHandler(){
			this.sendIndication({id: this.meter.meterId, value: +this.newValue})
				.then(
					d => this.newValue = null
				)
		},
		...mapActions(['sendIndication'])
	},
	mounted(){
		//console.log(this.meter)
	}
}
</script>
<style scooped lang="sass">
	.counter_box
		padding: 22px 60px 0 60px
</style>