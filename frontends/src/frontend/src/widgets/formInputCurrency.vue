<template>
	<b-col :md="col">
		<b-form-group
			:label="label"
			:label-for="name"
			:invalid-feedback="errors.first(`${name}`)"
			:decimalLength="decimalLength"
		>
			<currency-input
				:decimalLength="decimalLength"
				:disabled="disabled"
				:decimal="decimal"
				:id="name"
				v-model="inputVal"
				type="number"
				:name="name"
				:min="0"
				:state="_state"
				:checkMaximumInput="checkMaximumInput"
				:maximumInput="_maximumInput"
				:placeholder="pl"
			></currency-input>
		</b-form-group>
	</b-col>
</template>
<script>
export default {
	props: {
		pl: {
			type: String,
			default: '',
		},
		inputSize: {
			type: String,
			default: 'sm',
		},
		col: {
			type: Number,
			default: 12,
		},
		label: {
			type: String,
			default: '',
		},
		pl: {
			type: String,
			default: '',
		},
		validate: String,
		value: null,
		state: null,
		decimal: {
			type: Boolean,
			default: true,
		},
		disabled: {
			type: Boolean,
			default: false,
		},
		size: {
			type: String,
			default: 'sm',
		},
		// dataVvAs:String,
		// veeValidate:String,

		/**
		 * =========================================================
		 * * กำหนดให้ตรวจสอบค่าที่ป้อนเข้ามาห้ามเกิน ค่าที่กำหนด
		 * =========================================================
		 * @How_to
		 *  :check-maximum-input="true"
		 *  :maximum-input="100"
		 *
		 * !เช่น
		 *  maximum-input = 100 หมายถึงค่าที่กรอกเข้ามานั้นห้ามก่อน 100
		 */
		checkMaximumInput: {
			type: Boolean,
			default: true,
		},
		maximumInput: {
			type: [Number, String],
			default: 9999999999999999,
		},
		decimalLength: { type: Number, default: 2 },
		/**
		 * =========================================================
		 */
	},
	data() {
		return {
			dirty: false,
			placeholder: this.pl ? this.pl : '',
			name:
				`name_` + Math.floor(Math.random() * (0 - 999999 + 999999999999)) + 1,
			id: 'id' + Math.floor(Math.random() * (0 - 99 + 999)) + 1,
			inputVal: this.value,
			isHidden: false,
			fakeSalary: this.getLocaleString(this.value),
		}
	},
	mounted() {},
	computed: {
		_maximumInput() {
			return this.maximumInput * 1
		},
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
		inputVal(val) {
			this.fakeSalary = this.getLocaleString(val)
			this.$emit('input', val)
		},
		value(val) {
			this.dirty = true
			this.inputVal = val
			this.fakeSalary = this.getLocaleString(val)
			this.$emit('input', val)
		},
	},
	methods: {
		setHidden(bool) {
			if (this.value) this.$emit('input', parseFloat(this.value, 10).toFixed(2))
			this.isHidden = bool
			if (bool) this.$nextTick(() => this.$refs[this.id].focus())
		},
		getLocaleString(val, position) {
			if (val) {
				const fixed = parseFloat(val, 10).toFixed(
					position === undefined ? 2 : position
				)
				const temp = fixed.split('.')
				temp[0] = parseFloat(temp[0], 10).toLocaleString() || 0
				if (this.decimal) {
					return `${temp[0]}.${temp[1]}`
				} else {
					return temp[0]
				}
			}
			return ''
		},
	},
}
</script>
