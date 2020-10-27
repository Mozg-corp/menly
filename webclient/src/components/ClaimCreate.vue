<template>
	<div id="claimsCreate" class="profile_container__main claims">
		<h2 class="cabinet_header">
			НАПИШИТЕ НАМ ОБРАЩЕНИЕ
		</h2>	
		<div class="claim_container r-flex">
			<div class="claim_row r-flex">
				<div >
					<label for="claim_title" class="row_header">
						Тема:
					</label>
				</div>
				<div class="field_container">
					<input 
						name="claim_title"
						v-model="claim.title"
						class="row_content"
						placeholder="Например: сломалась разетка"
						>
					</input>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<label for="claim_content" class="row_header">
						Текст:
					</label>
				</div>
				<div class="field_container">
					<textarea 
						name="claim_content"
						v-model="claim.text"
						class="row_content"
						placeholder="Введите текст"
						>
						
					</textarea>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<p class="row_header">
						Фото:
					</p>
				</div>
				<div class="field_container">
					<p class="row_content">
					</p>
				</div>
			</div>
			<div class="claim_row r-flex">
				<div >
					<label for="claimer_phone" class="row_header row_header__last">
						Телефон для связи:
					</label>
				</div>
				<div class="field_container">
					<input
						name="claimer_phone"
						v-model="claim.phoneNumber"
						class="row_content"
						placeholder="+7 (985) 123-45-67">
					</input>
				</div>
			</div>
			<a :class="{ 'send_claim': true, 'empty': isEmpty}" @click.prevent="sendClaimHandler" >
				Отправить
			</a>
		</div>
	</div>
</template>
<script>
	import {mapActions} from 'vuex';
	export default{
		name: "CreateClaim",
		data: ()=>({
			claim: {
				title: "",
				text: "",
				phoneNumber: ""
			}
		}),
		computed: {
			isEmpty(){
				return this.claim.title.length < 5 || this.claim.text.length < 5 || this.claim.phoneNumber === ''
			}
		},
		methods: {
			sendClaimHandler(){
				if(!this.isEmpty){
					this.createClaim(this.claim)
						.then(
							()=>this.$router.go(-1)
						)
						.catch(
							e => alert(e.response.data.message)
						)
				}
			},
			...mapActions(['createClaim'])
		}
	}
</script>
<style scoped lang="sass">
	.claim_container
		flex-direction: column
		align-items: flex-start
		padding: 41px 0 0 0
		width: 100%
		font-size: 18px
		color: #000000
	.claims
		width: 100%
	.row_header
		padding: 0 120px 0 0
	.row_header__last
			padding: 0 40px 0 0
	.claim_row
		margin: 10px 0
		width: 100%
	.field_container
		width: 100%
	.row_content
		width: 100%
		font-weight: 300
		font-size: 24px
		line-height: 29px
		border: 1px solid #C4C4C4
		padding: 3px 20px
		box-shadow: inset 2px 2px 2px 2px rgba(0, 0, 0, 0.25)
		border-radius: 5px
	.send_claim
		font-weight: 500
		font-size: 18px
		line-height: 38px
		color: #000000
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		background-color: #EDEDED
		border-radius: 10px
		padding: 8px 120px
		margin: 48px auto
	.empty
		cursor: not-allowed
		color: gray
</style>