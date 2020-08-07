<template>
  <v-app id="inspire">
    <v-navigation-drawer
        v-model="drawer"
        :clipped="$vuetify.breakpoint.lgAndUp"
        app
		temporary
    >
      <v-list dense>
        <template v-for="item in items">
          <v-layout
              v-if="item.heading"
              :key="item.heading"
              row
              align-center
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex
                xs6
                class="text-xs-center"
            >
              <a
                  href="#!"
                  class="body-2 black--text"
              >EDIT</a>
            </v-flex>
          </v-layout>
          <v-list-group
              v-else-if="item.children"
              :key="item.text"
              v-model="item.model"
              :prepend-icon="item.model ? item.icon : item['icon-alt']"
              append-icon=""
          >
            <template v-slot:activator>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>
                    {{ item.text }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
                v-for="(child, i) in item.children"
                :key="i"
                @click=""
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
              v-else
              :key="item.text"
              :to="item.url"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>

      <div v-if="$store.getters.isAuthenticated">
      <div class="pa-2">
        <v-btn block @click.prevent="logout"><v-icon left>lock</v-icon>Logout</v-btn>
      </div>
    </div>
      <div v-else>
        <div class="pa-2">
          <v-btn block @click.prevent="signIn"><v-icon left>lock_open</v-icon>Login</v-btn>
        </div>
        <div class="pa-2">
          <v-btn block @click.prevent="signUp"><v-icon left>assignment_ind</v-icon>Signup</v-btn>
        </div>
      </div>
    </v-navigation-drawer>
    <v-app-bar
        :clipped-left="$vuetify.breakpoint.lgAndUp"
        app
		flat
		dense
    >
	<v-app-bar-nav-icon @click.stop="drawer = !drawer" ></v-app-bar-nav-icon>
	<router-link :to="{ name: 'home'}" >
		<svg width="108" height="46" viewBox="0 -7 108 46" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<rect width="108" height="46" fill="url(#pattern0)"/>
			<defs>
				<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
					<use xlink:href="#image0" transform="translate(0 -0.00328807) scale(0.00108814 0.00255476)"/>
				</pattern>
				<image id="image0" width="919" height="394" xlink:href="data:image/png;base64,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"/>
			</defs>
		</svg>
	</router-link>
      <v-toolbar-title
          style="width: 300px"
          class="ml-0 pl-3"
      >
		<span class="title font-weight-black blue--text lighten-2">
			СНТ “ЛУЧ”
		</span>
      </v-toolbar-title>
	  <v-spacer></v-spacer>
      <div v-if="$store.getters.isAuthenticated">
        <v-btn @click.prevent="logout" text >
			Выйти {{username}}
		</v-btn>
      </div>
      <div v-else>
        <router-link :to="{name: 'signin'}" class="text-body-1 " >Вход</router-link> /
        <router-link :to="{name: 'signup'}" class="text-body-1" >Регистация</router-link>
      </div>

      <v-btn
          large
          @click="dialogAuthorization = !dialogAuthorization"
        <v-avatar
            size="32px"
            item
          <v-img
              src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
              alt="Vuetify"
          </v-img>
        </v-avatar>
      </v-btn>
	  <v-spacer></v-spacer>
	   <template v-slot:extension >
			<v-layout class="d-flex justify-center ">
				<v-list  rounded class="pa-0">
					<v-list-item-group v-model="item" class="d-flex justify-center pa-0">
						<v-list-item class="pa-0 mb-0 mr-5">
							<v-list-item-content >
								<v-list-item-title>Single-line item</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						<v-list-item class="pa-0 mb-0 mr-5">
							<v-list-item-content >
								<v-list-item-title>Single-line item</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						<v-list-item class="pa-0 mb-0 mr-5">
							<v-list-item-content >
								<v-list-item-title>Single-line item</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						<v-list-item class="pa-0 mb-0 mr-5">
							<v-list-item-content >
								<v-list-item-title>Single-line item</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						<v-list-item class="pa-0 mb-0 mr-5">
							<v-list-item-content >
								<v-list-item-title>Single-line item</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					</v-list-item-group>
				</v-list>
			</v-layout>
      </template>
    </v-app-bar>
    <v-content>
      <v-container
          fluid
      >
        <v-layout
        >

          <br>
          <router-view></router-view>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
    import store from './store/index';

    export default {
        components: {
        },
        data: () => ({
            dialog: false,
            dialogAuthorization: false,
            dialogRegistration: false,
            drawer: null,
            source: '/',
            items: [
                {icon: 'home', text: 'Главная', url: {name: 'home'}},
                //{icon: 'shop', text: 'Магазины', url: {name: 'shops'}},
                // {
                //     icon: 'keyboard_arrow_up',
                //     text: 'Профиль',
                //     'icon-alt': 'person',
                //     model: false,
                //     children: [
                //         {icon: 'add', text: 'Create label'},
                //     ],
                // },
                // {icon: 'history', text: 'Frequently contacted'},
                // {icon: 'content_copy', text: 'Duplicates'},
                // {
                //     icon: 'keyboard_arrow_up',
                //     'icon-alt': 'keyboard_arrow_down',
                //     text: 'Labels',
                //     model: true,
                //     children: [
                //         {icon: 'add', text: 'Create label'},
                //     ],
                // },
                // {
                //     icon: 'keyboard_arrow_up',
                //     'icon-alt': 'keyboard_arrow_down',
                //     text: 'More',
                //     model: false,
                //     children: [
                //         {text: 'Import'},
                //         {text: 'Export'},
                //         {text: 'Print'},
                //         {text: 'Undo changes'},
                //         {text: 'Other contacts'},
                //     ],
                // },
                // {icon: 'settings', text: 'Settings'},
                // {icon: 'chat_bubble', text: 'Send feedback'},
                // {icon: 'help', text: 'Help'},
                // {icon: 'phonelink', text: 'App downloads'},
                // {icon: 'keyboard', text: 'Go to the old version'}
            ],

        }),

        methods: {
            logout(){
              this.$store.dispatch('logout')
                  .then(()=>{
                      this.$router.push('/sign-in')
                  })
            },
            registrationSave() {
                console.log("registrationSave");
            },

            registrationClose() {
                this.dialogRegistration = !this.dialogRegistration;
                this.dialogAuthorization = !this.dialogAuthorization;
            },

            authorization() {
                console.log("authorization");
            },
            signIn(){
                this.$router.push({name: 'signin'})
            },
            signUp(){
                this.$router.push({name: 'signup'})
            }

        },
        computed: {
            username(){
                // console.log( this.$store.getters.getUsername);
                return this.$store.getters.getUsername;
            }
        },
        mounted() {
			console.log(this.$store.getters.isAuthenticated);
        }

    };
</script>
<style scoped lang="sass">
.info
	margin: 50px
	color: white
	padding: 10px
.router-link
	margin_bottom: 50px
.menu
	display: flex
	justify-content: center
</style>