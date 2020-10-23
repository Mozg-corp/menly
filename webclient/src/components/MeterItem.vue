<template>
	<div class="meters_box__item">
		<div class="meter_item__col">
			<p>
				{{meter.houseNumber}}
			</p>
		</div>
		<div class="meter_item__col">
			<p>
				{{meter.accountId}}
			</p>
		</div>
		<div class="meter_item__col">
			<p>
				<router-link :to="{name: 'meters single', params: {id: meter.meterId}}">
					{{meter.serialNumber}}
				</router-link>
			</p>
		</div>
		<div class="meter_item__col">
			<p>
				{{meter.model}}
			</p>
		</div>
		<div class="meter_item__col">
			<p>
				{{meter.currentMeterData.value}}
			</p>
		</div>
		<div class="meter_item__col">
			<input name="currentMeterValue" type="number" v-model="value">
		</div>
	</div><!--meter_box_item-->
</template>
<script>
	export default{
		name: "MeterItem",
		props: ['meter'],
		data: ()=>({
			value: null
		}),
		computed: {
		},
		mounted(){
			console.log(this.meter)
		}
	}
</script>
<style scoped lang="sass">
</style>