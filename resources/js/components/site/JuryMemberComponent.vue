<template>
    <div>
        <section class="sections main-section jury-member juries">
            <div class="container">
                <div class="page-nav">
                   <router-link :to="{ name: 'juries'}" class="prev-page"><i class="fa fa-angle-left"></i>все журі</router-link>
                </div>
                <div class="member-jury-card" v-for="(item, index) in juryMember" :key="index">
                    <div class="picture">
                       <img v-bind:src="item.photo" alt="">
                    </div>
                    <div class="description">
                        <h3 class="title-description">{{ `${item.name} ${item.surname}` }}</h3>
                        <div class="text-description">{{ item.rank }}<br>
                           {{ item.nominations.replace(";", ", ") }}
                            <span v-if="item.regalia"><br>Регалії: {{ item.regalia }}</span>
                        </div>
                        <div class="text-description">
                            <span style="white-space: pre-wrap">{{ item.informations }}</span>
                        </div>
                   </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                juryMember: [],
            };
        },

        created () {
            document.title = "Представник журі";
	        this.getJuryList();
        },
        computed: {

        },
	    methods: {
		    getJuryList() {
			    axios.get('/get-jury-view/'+this.$route.params.id)
				    .then((response) => {
					    this.juryMember.push(...response.data)
				    })
		    },
	    },

    }
</script>
