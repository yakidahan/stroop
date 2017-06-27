<template>
    <div class="container" @keydown="down">
        <div class="panel panel-default text-center">
            <div class="panel-heading"><h1>Stroop Effect</h1></div>

            <div class="panel-body">
                <div class="intro" v-if="screen === 'intro'">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <p>במהלך הניסוי יופיעו מילים שונות בצבעים שונים. הנך מתבקש/ת ללחוץ במהירות המירבית על מקש <kbd>1</kbd> כאשר המילה רשומה בצבע <span class="red">אדום</span>, וללחוץ על מקש <kbd>2</kbd> כאשר המילה רשומה בצבע <span class="green">ירוק</span>.<br>
                            <!-- המילים הראשונות שיוצגו בפניך הינם לצורך אימון, וכאשר את/ה מרגיש/ה מוכן/ה לחץ/צי על לחצן התחל/י ע"מ להתחיל בניסוי.<br> -->
                            כל המידע הינו חסוי לחלוטין, והינך יכול/ה לפרוש מהניסוי מתי שתרצה/י.</p>
                            <button type="button" class="btn btn-default btn-lg" @click="play">התחל/י</button>
                        </div>
                    </div>
                </div>

                <div class="player" v-if="screen === 'player'">
                    <input type="text" class="form-control input-lg text-center"
                        :style="'color: ' + option.color"
                        :value="option.text"
                        readonly="readonly"
                        autofocus="autofocus">
                </div>

                <div class="end" v-if="screen === 'end'">
                    <h2>תודה!</h2>
                    <button type="button" class="btn btn-default btn-lg" @click="replay">חזרה להתחלה</button>
                </div>
            </div>

            <div class="panel-footer">
                <span>© צדוק לבן & אלדד מדי</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                storing: false,
                screen: 'intro',
                step: 0,
                timer: 0,
                status: 'Ready?',
                option: {},
                results: [],
                options: [
                    {
                        lang: 'en',
                        text: 'Red',
                        color: '#e74c3c',
                    }, {
                        lang: 'en',
                        text: 'Green',
                        color: '#e74c3c',
                    }, {
                        lang: 'en',
                        text: 'Green',
                        color: "#2ecc71",
                    }, {
                        lang: 'en',
                        text: 'Red',
                        color: "#2ecc71",
                    }, {
                        lang: 'he',
                        text: 'אדום',
                        color: '#e74c3c',
                    }, {
                        lang: 'he',
                        text: 'ירוק',
                        color: '#e74c3c',
                    }, {
                        lang: 'he',
                        text: 'ירוק',
                        color: "#2ecc71",
                    }, {
                        lang: 'he',
                        text: 'אדום',
                        color: "#2ecc71",
                    },
                ],
            };
        },

        mounted() {
            
        },

        methods: {
            play() {
                this.screen = 'player';
                this.timer = new Date();
                this.option = this.options[this.step];
            },

            down(e) {
                if (e.keyCode === 49 || e.keyCode === 50 || e.keyCode === 97 || e.keyCode === 98) {
                    let time = new Date() - this.timer;

                    this.options[this.step].time = time;

                    if (e.keyCode === 49 || e.keyCode === 97) {
                        if (this.option.color === '#e74c3c') {
                            this.options[this.step].status = 'Correct';
                        } else {
                            this.options[this.step].status = 'Wrong';
                        }
                    } else if (e.keyCode === 50 || e.keyCode === 98) {
                        if (this.option.color === '#2ecc71') {
                            this.options[this.step].status = 'Correct';
                        } else {
                            this.options[this.step].status = 'Wrong';
                        }
                    }

                    this.continue();
                }
            },

            continue() {
                this.timer = new Date();

                if (this.step < this.options.length-1) {
                    this.step ++;
                    this.option = this.options[this.step];
                } else {
                    this.store();
                    
                    console.log(this.options);

                    this.screen = 'end';
                    this.step = 0;
                }
            },

            replay() {
                this.screen = 'intro';
                this.step = 0;
            },

            store() {
                this.storing = true;

                axios.post('/api/test', this.options)
                    .then(response => {
                        this.storing = false;
                    })
                    .catch(error => {
                        this.storing = false;

                        if (error.response) {
                            console.log(error.response.status);
                        } else {
                            console.log(error.message);
                        }
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .panel-heading, .panel-footer {
        border: none;
        color: #2c3e50;
        background: #bdc3c7;
    }
    .panel-body {
        color: #fff;
        background: #2c3e50;
        p {
            text-align: right;
            font-size: 22px;
            .red {
                color: #e74c3c;
            }
            .green {
                color: #2ecc71;
            }
        }
        .player {
            input {
                background: transparent;
                border: none;
                font-weight: 300;
                height: auto;
                font-size: 120px;
                box-shadow: none;
            }
        }
    }
</style>
