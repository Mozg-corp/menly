<template>
	<div class="claims_box__item r-flex" @click.prevent="$router.push({name: 'single claim admin', params: {id: claim.id} })">
		<div class="claim_item__col1">
			<p>
				{{claim.creationDate}}
			</p>
		</div>
		<div class="claim_item__col2">
			<p>
				{{claim.id}}
			</p>
		</div><div class="claim_item__col3">
			</router-link>
		</div>
		<div class="claim_item__col4">
			<p :class="status">
				{{claim.status}}
			</p>
		</div>
	</div><!--claim_box_item-->
</template>
<script>
	export default{
		name: "ClaimItemAdmin",
		props: ['claim'],
		computed: {
		  status: function () {
				return {
				  sended: this.claim.status === 'Направлено',
				  inwork: this.claim.status === 'В работе',
				  canceled: this.claim.status === 'Отменено',
				  done: this.claim.status === 'Выполнено',
				  recieved: this.claim.status === 'Получено'
				}
			}
		}
	}
</script>
<style scoped lang="sass">
	.claims_box__item:hover
		background-color: grey
		opacity: 0.5
		color: white
	a
		font-size: 18px
		line-height: 22px
		color: #000000
	.sended
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background: #EFEFEF
		border-radius: 10px
		text-align: center
		line-height: 25px
		padding: 3px 12px
		font-size: 16px
		color: #929292
	.inwork
		background: #E2EDFA
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		text-align: center
		line-height: 25px
		padding: 3px 12px
		font-size: 16px
		color: #929292
	.canceled
		background: #FFE2E1
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		text-align: center
		line-height: 25px
		padding: 3px 12px
		font-size: 16px
		color: #929292
	.done
		background: #EBF4E8
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		text-align: center
		line-height: 25px
		padding: 3px 12px
		font-size: 16px
		color: #929292
	.recieved
		background: #EBF4E8
		border-radius: 10px
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		text-align: center
		line-height: 25px
		padding: 3px 12px
		font-size: 16px
		color: #929292
		min-width: 125px
</style>