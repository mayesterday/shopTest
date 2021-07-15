<template>
	<b-col :md="col">
		<b-form-group :label-for="name" :invalid-feedback="errors.first(name)">
			<label>
				{{ label }}
				<font color="red" v-if="star">*</font>
			</label>
			<b-form-input
				:type="type"
				:id="name"
				:name="name"
				v-model="vModel"
				:state="_state"
				@input="_handlerInput"
				v-if="!textarea"
				:disabled="disabled"
				class="form-control"
				autocomplete="off"
				v-bind="getProps()"
				size="sm"
				style="height: 35px;"
				:placeholder="placeholder"
			/>

			<!-- 
                Form text area
			-->
			<b-form-textarea
				:disabled="disabled"
				class="form-control"
				:name="name"
				:id="name"
				:rows="textareaRow"
				@input="_handlerInput"
				v-model="vModel"
				:state="_state"
				autocomplete="off"
				v-else
			>{{ vModel }}</b-form-textarea>
			<!-- 
        Show Error
			-->
			<!-- <div id="input-live-feedback" class="invalid-feedback" v-if="_error">
        {{ errors.items.find(f => f.field === name).msg }}
			</div>-->
			<div
				id="helpId"
				class="form-text text-danger"
				v-if="errors.items.find(f => f.field === name)"
			>{{ errors.items.find(f => f.field === name).msg }}</div>
		</b-form-group>
	</b-col>
</template>

<script>
export default {
	props: {
		star: Boolean,
		/**
     * @type
     *  'text',
          'password',
          'email',
          'number',
          'url',
          'tel',
          'date',
          `time`,
          'range',
          'color'
     */
		type: {
			type: String,
			default: 'search',
		},
		size: {
			type: String,
			default: 'sm',
		},

		col: {
			type: Number,
			default: 12,
		},
		pl: {
			type: String,
			default: '',
		},

		textarea: {
			type: Boolean,
			default: false,
		},
		textareaRow: {
			type: Number,
			default: 2,
		},

		/**
		 * @param label
		 * ข้อความหัวข้อ
		 */
		label: {
			type: String,
			default: '',
		},

		disabled: {
			type: Boolean,
			default: false,
		},
		state: null,
		/**
		 * @param ข้อมูลที่ต้องเอามาแสดงที่ช่องป้อนข้อมูล
		 */
		value: null,
		// name: {
		//   type: String,
		//   default: 'name_'
		// }
		min: {
			type: Number,
			default: null,
		},
		max: {
			type: Number,
			default: null,
		},
	},
	computed: {
		_state() {
			let val = this.value
			let error = this._error
			if (!val && !this.dirty) {
				return null
			} else if (error) {
				return false
			} else {
				return true
			}
		},
		_error() {
			return this.errors.items.find((f) => f.field === this.name)
		},
	},
	watch: {
		value(val) {
			this.dirty = true
			this.vModel = val
		},
	},
	data() {
		return {
			dirty: false,
			name:
				`name_` + Math.floor(Math.random() * (0 - 999999 + 999999999999)) + 1,
			vModel: this.value,
			placeholder: this.pl ? this.pl : '',
		}
	},
	methods: {
		_handlerInput(value) {
			if (value) {
				this.$emit('input', this.vModel)
			} else {
				this.$emit('input', value)
			}
		},
		getProps() {
			let obj = {}
			if (this.min != null) {
				obj.min = this.min
			}
			if (this.max != null) {
				obj.max = this.max
			}
			return obj
		},
	},
}
</script>

<style></style>
