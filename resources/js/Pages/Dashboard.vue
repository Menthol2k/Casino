<template>
    <Head :title="'Pacanea'" />

    <div class="flex justify-center mt-4">
        <h1 class="font-semibold text-3xl"><span class="text-red-500">Rosie</span> / <span>Neagra</span></h1>
    </div>

    <div class="bg-white rounded-xl shadow p-3 w-11/12 md:w-7/12 mx-auto mt-10">

        <h1>Balanta: {{ balance }} Ron</h1>

        <!-- <pre>{{ $page.props.auth.user }}</pre> -->

        <div class="flex justify-center my-5">
            <h1 :class="win ? 'text-green-500' : 'text-red-500'" class="text-4xl font-bold" v-if="showValue">{{ win ?
                'Castigat' : 'Pierdut' }}</h1>
            <h1 :class="win ? 'text-green-500' : 'text-red-500'" class="text-4xl font-bold">&nbsp;</h1>
        </div>

        <div class="flex justify-center space-x-5">
            <div>
                <button :disabled="showValue" :class="showValue ? 'bg-gray-600' : ''" @click="redCard" title="Rosie"
                    class="active:scale-95 rounded-lg transition-all shadow hover:shadow-lg shadow-red-500 bg-red-500 text-white font-semibold text-xl w-[130px] md:w-[220px] h-[200px] md:h-[330px]">Rosie</button>
            </div>
            <div>
                <button :disabled="showValue" :class="showValue ? 'bg-gray-600' : ''" @click="blackCard" title="Neagra"
                    class="active:scale-95 rounded-lg transition-all shadow hover:shadow-lg shadow-black bg-gray-900 text-white font-semibold text-xl w-[130px] md:w-[220px] h-[200px] md:h-[330px]">Neagra</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div v-if="history.length > 0" class="flex justify-center space-x-1 mt-6">
                <div v-for="his in history" :key="his">
                    <div class="bg-green-500 w-[70px] h-[100px] text-white flex justify-center items-center rounded-md border border-black"
                        v-if="his == '1'">
                        <h1>Castig</h1>
                    </div>
                    <div class="text-white bg-red-500 w-[70px] h-[100px] text-8white flex justify-center items-center rounded-md border border-black"
                        v-if="his == '0'">
                        <h1>Pierdut</h1>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div>
                <h1 class="text-gray-800 mt-6 font-semibold text-3xl">Top jucatori</h1>
            </div>
            <div class="mt-2">
                <ul>
                    <li class="text-gray-800 font-semibold text-lg" v-for="scor in score" :key="scor.win_count">{{ scor.player_name }}: {{ scor.win_count }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {

    components: {
        Head,
    },

    data() {
        return {
            showValue: false,
            win: false,
            winRate: 50,
            history: [],
        }
    },

    computed: {
        filteredHistory() {
            return this.history;
        }
    },

    props: {
        score: Object,
        balance: Number,
    },

    methods: {
        redCard() {
            var winRate = 100 - this.winRate;
            var randNum = Math.floor(Math.random() * (100 - 0 + 1)) + 0;
            if (randNum > winRate) {
                this.win = true;
                this.addScore('1');
                this.history.push(1);
            } else {
                this.win = false;
                this.addScore('0');
                this.history.push(0);
            }
            this.showValue = true;
            setTimeout(() => {
                
                this.showValue = false;
            }, 1400)
        },
        blackCard() {
            var winRate = 100 - this.winRate;
            var randNum = Math.floor(Math.random() * (100 - 0 + 1)) + 0;
            if (randNum > winRate) {
                this.win = true;
                this.history.push(1);
                this.addScore('1');

            } else {
                this.win = false;
                this.addScore('0');
                this.history.push(0);
            }
            this.showValue = true;
            setTimeout(() => {
                this.showValue = false;
            }, 1400)
        },
        addScore(win){
            axios.post(`/score/${win}`)
                .then((response) => {
                    this.$inertia.visit('/dashboard')
                });

        }
    },

    layout: Layout,

}

</script>