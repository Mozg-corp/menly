<template>
	<div>
		<div class="container_my">
			<div class="cabinet_container profile_container r-flex">
				<section class="cabinet_personal">
						<h2>
							АДМИНКА
						</h2>
						<div class="cabinet_personal_line"></div>
						<article>
							<div class="cabinet_top r-flex">
								<!--<img src="" alt="user foto">-->
								<div class="cabinet_fio">
									<p>
										{{username}}
									</p>
									<p>
										
									</p>
									<p class="cabinet_phone">
										
									</p>
								</div>
							</div>
							<!-- Tab links -->
							<div class="cabinet_bottom">
								<router-link class="cabinet__link" :to="{name: 'cityzens'}">Жители</router-link>
								<router-link class="cabinet__link" :to="{name: 'meters list'}">Счётчики</router-link>
								<router-link class="cabinet__link" :to="{name: 'payments list'}">Платежи</router-link>
								<router-link class="cabinet__link" :to="{name: 'claims list'}">Обращения</router-link>
								<router-link class="cabinet__link" :to="{name: 'votes list'}">Голосования</router-link>
							</div>
						</article>
					</section>
				<main class="r-flex">
					<router-view :key="$route.path"/>
				</main>
				
			</div><!--profile_container-->
			</div>
	</div>
</template>

<script>
// @ is an alias to /src
import {mapState} from 'vuex';

export default{
	name: "Admin",
	data: ()=>({
	
	}),
	computed: {
		...mapState(['username'])
	}
}
</script>
<style lang='sass' scoped>
	.cabinet__link
		word-break: break-all
		width: 290px
		display: block
		font-weight: normal
		font-size: 20px
		line-height: 24px
		text-align: left
		box-sizing: border-box
		color: #000000
		padding: 10px 45px
		border: 0.2px solid #000000
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25)
		border-radius: 5px
		margin: 17px 0 0 0
		background-color: #FFF
	.cabinet__link:hover
		border: 1px solid blue
</style>