<template>
	<main >
		<div class="container">
			<div class="about_container">
				<section class="about_history">
					<h2>
						НАША ИСТОРИЯ
					</h2>
					<article>
						<div class="memorial">
							<img :src="imgs.memorial" alt="memorial foto">
							<p >
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum. Donec elit nibh, hendrerit et metus eget, sollicitudin fringilla eros. Proin venenatis, felis eu egestas porta, magna ipsum suscipit nisl, ut dignissim odio odio sed mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis odio lectus, volutpat sit amet placerat eget, consectetur a sem. Vestibulum ac accumsan urna.
							</p>
						</div>
						<div class="memorial_line"></div>
					</article>
				</section><!--about_history-->
				<section class="about_management">
					<h2>
						РУКОВОДСТВО
					</h2>
					<article>
						<div class="about_chairman r-flex">
							<img :src="imgs.chairman" alt="chairman">
							<div>
								<h3>
									ПРЕДСЕДАТЕЛЬ
								</h3>
								<p >
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum.
								</p>
							</div>
						</div>
					</article>
					<article>
						<div class="about_chairman r-flex">
							<img :src="imgs.member1" alt="member1">
							<div>
								<h3>
									ЧЛЕН ПРАВЛЕНИЯ №1 
								</h3>
								<p >
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum.
								</p>
							</div>
						</div>
					</article>
					<article>
						<div class="about_chairman r-flex">
							<img :src="imgs.member2" alt="member2">
							<div>
								<h3>
									ЧЛЕН ПРАВЛЕНИЯ №2 
								</h3>
								<p >
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum.
								</p>
							</div>
						</div>
						<div class="memorial_line"></div>
					</article>
				</section><!--about_management-->
				<section class="about_revision">
					<h2>
						РЕВИЗИОННАЯ КОМИССИЯ
					</h2>
					<article>
						<div class="about_chairman r-flex">
							<img :src="imgs.chairman" alt="chairman">
							<div>
								<h3>
									ПРЕДСЕДАТЕЛЬ
								</h3>
								<p >
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum.
								</p>
							</div>
						</div>
					</article>
					<article>
						<div class="about_chairman r-flex">
							<img :src="imgs.member1" alt="member1">
							<div>
								<h3>
									ЧЛЕН ПРАВЛЕНИЯ №1 
								</h3>
								<p >
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum.
								</p>
							</div>
						</div>
					</article>
					<article>
						<div class="about_chairman r-flex">
							<img :src="imgs.member2" alt="member2">
							<div>
								<h3>
									ЧЛЕН ПРАВЛЕНИЯ №2 
								</h3>
								<p >
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque condimentum quam. Aenean eu consequat elit. Curabitur congue malesuada mi, vel blandit justo efficitur ac. Pellentesque accumsan ut urna eget commodo. Cras blandit urna a dignissim sollicitudin. In at dui ac diam euismod varius. Phasellus fringilla sollicitudin nisl vel fermentum.
								</p>
							</div>
						</div>
						<div class="memorial_line"></div>
					</article>
				</section><!--about_revision-->
			</div>	<!--about_container-->
		</div><!--container-->
	</main> <!--main-->
</template>
<script>
	export default{
		name: 'About',
		data: ()=>({
			imgs: {
				"chairman": './img/about_page/chairman.png',
				"member1": './img/about_page/member1.png',
				"member2": './img/about_page/member2.png',
				"memorial": './img/about_page/memory.png'
			}
		}),
		mounted(){
			
		}
	}
</script>
