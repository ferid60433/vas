const sl = require('./SmsLength');

let smsLength = new sl.SmsLength();

Vue.component('message-textarea', {
    props: {
        name: {type: String},
        message: {type: String, default: ''}
    },
    data() {
        return {};
    },

    computed: {
        stat() {
            smsLength.message = this.message;

            return smsLength.left() + '/' + smsLength.parts();
        }
    },

    template: `<div>
        <textarea required v-bind:id="name" v-bind:name="name" class="form-control" rows="3"
                  v-model="message" style="height: auto !important;"></textarea>
        <strong>
            <code class="form-control-feedback pull-right" v-text="stat"></code>
        </strong>
    </div>`
})
