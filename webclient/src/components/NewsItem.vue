<template>
	<article v-show="news.id!==editingId" :class="[card_news, news.pinned? pinned:'']">
		<img src="https://via.placeholder.com/165X120" alt="news foto">
		<div class="card_news__body">
			<div :class="['card_header', news.pinned? 'card_header__impotant' : '']">
				<h3>
					{{news.title}}
				</h3>
				<p v-if="cut">
					{{news.fullText.substr(0,60)}}
				</p>
				<p v-else>
					{{news.fullText}}
				</p>
			</div>
			<div class="card_news__controls r-flex">
				<a href="#" v-if="cut" @click.prevent="cut=!cut">
					подробнее >
				</a>
				<a href="#" v-else @click.prevent="cut=!cut">
					< меньше
				</a>
				<div  v-show="isAdmin === true">
					<!--<a href="#">-->
					<!--	Закрепить-->
					<!--</a>-->
					<a href="#" @click.prevent="$emit('editing', news.id)">
						Редактировать
					</a>
				</div>
			</div>
		</div>
		<div class="card_news__date r-flex">
			<p>
				{{news.creationDate}}
			</p>
			<p  v-show="isAdmin">
				<!--<a href="#">-->
				<!--	Удалить-->
				<!--</a>-->
			</p>
		</div>
	</article>
</template>
<script>
	import {mapGetters} from 'vuex';
	export default{
		name: 'NewsItem',
		props: ['news', 'editingId'],
		data: ()=>({
			card_news: 'card_news r-flex',
			pinned: 'pinned',
			important: 'card_header__impotant',
			card_header: 'card_header',
			cut: true
		}),
		computed: {
			...mapGetters(['isAdmin'])
		},
		mounted(){
			//console.log(this.news)
		}
	}
</script>
<style scoped lang="sass">
	.card_news__date p
		width: 90px
</style>