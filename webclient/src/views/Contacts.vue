<template>
	<main >
		<div class="container">
			<div class="contacts_container">
				<h1>
					{{requisites.companyName}} <a href="#" v-show="!editable&&isAdmin" @click.prevent="editable=!editable">Редактировать</a> <a href="#" v-show="editable" @click.prevent="cancelHandler">Завершить</a>
				</h1>
				<form name="contacts" method="post" action="#">
					<section class="contacts_section">
						<h2 class="contact_header">
							Контакты
						</h2>
						<ContactItem v-for="item in contact" :key="item.id" :title="item.title" :text="item.text" :id="item.id" :disabled="!editable"/>
						<article>
							<div class="contact r-flex">
								<input :disabled="!addField" type="text" v-model="title" placeholder="Название поля" class="field_name"/>
								<input :disabled="!addField" type="text" v-model="text" placeholder="Значение поля" class="field_value"/>
							</div>
						</article>
						<a href="#" v-show="editable&&!addField" @click.prevent="addField=!addField">Новое поле</a><a v-show="addField" href="#" @click.prevent="addFieldHandler"> Добавить это поле</a>
					</section>
					<section class="requisites_section">
						<h2 class="requisites_header">
							Реквизиты
						</h2>
						<article>
							<h3 class="company_name">
								{{requisites.companyName}} 
							</h3>
							<div class="requisites_details  r-flex">
								
								<label for="inn" class="inn">
									ИНН:
								</label>
								<input :disabled="!editable" type="number" name="inn" :value="requisites.inn"/>
							</div>
						</article>
						<article>
							<div class="requisites_details  r-flex">
								
								<label for="kpp" class="kpp">
									КПП:
								</label>
								<input :disabled="!editable" type="number" name="kpp" :value="requisites.kpp">
							</div>
						</article>
						<article>
							<div class="requisites_details  r-flex">
								
								<label for="ogrn" class="ogrn">
									ОГРН:
								</label>
								<input :disabled="!editable" type="number" name="ogrn" :value="requisites.ogrn"/>
							</div>
						</article>
						<article>
							<div class="requisites_details  r-flex">
								
								<label for="account" class="account">
									Р/С:
								</label>
								<input :disabled="!editable" type="number" name="account" :value="requisites.bankAccount"/>
							</div>
						</article>
						<article>
							<div class="requisites_details  r-flex">
								
								<label for="kc" class="kc">
									К/С:
								</label>
								<input :disabled="!editable" type="number" name="kc" :value="requisites.correspondentAccount"/>
							</div>
						</article>
						<article>
							<div class="requisites_details r-flex">
								
								<label for="bic" class="bic">
									БИК:
								</label>
								<input :disabled="!editable" type="number" name="bic" :value="requisites.bik"/>
							</div>
						</article>
					</section>
				</form>
			</div><!--contacts_container-->
		</div><!--container-->
	</main> <!--main-->
</template>
<script>
	import {mapActions, mapState, mapGetters} from 'vuex';
	import ContactItem from '@/components/ContactItem.vue';
	export default{
		name: "Contacts",
		components: {ContactItem},
		data: ()=>({
			editable: false,
			loading: false,
			addField: false,
			title: "",
			text: "",
			disabled: ""
		}),
		computed: {
			contact: {
				get(){
					return this.$store.getters.getContact
				},
				set(){
					
				}
			},
			...mapState(['requisites']),
			...mapGetters(['isAdmin'])
		},
		methods: {
			addFieldHandler(){
				this.createNewContactField({hidden:false,title: this.title, text: this.text})
					.then(()=>{
						this.addField = false;
						this.title = "";
						this.text = "";
					})
					.catch(e=> console.log(e))
			},
			cancelHandler(){
				this.editable=!this.editable;
				this.addField = false;
				this.title = "";
				this.text = "";
			},
			...mapActions(['fetchContact', 'createNewContactField', 'fetchRequisites'])		
		},
		mounted(){
			this.loading = true;
			this.fetchContact()
				.then(
					contact => {
						this.loading = false;
					}
				)
			this.fetchRequisites()
				.then(
					(r)=>console.log(r)
				).catch(
					e=> console.log(e)
				)
			//contact.filter((el)=>{el.title === "описание раздела 1"}
			
		}		
	}
</script>
<style scoped lang="sass">
	form label
		min-width: 170px
	.field_value
		flex-grow: 3
		font-weight: normal
		font-size: 20px
		line-height: 24px
		word-break: break-all
		font-weight: 300
		background-color: -internal-light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))
	input, textarea
		background-color: rgba(239, 239, 239, 0.3)
	input:disabled, textarea:disabled
		border: 1px solid #FFF
		background-color:  #FFF
	label
		min-width: 170px
	.field_name:disabled::placeholder,
	.field_value:disabled::placeholder
		color: #FFF

</style>