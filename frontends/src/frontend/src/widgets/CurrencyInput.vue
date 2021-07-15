<template>
	<div>
		<b-input-group>
			<!-- ส่วนหัวถ้ามี prop -->
			<b-input-group-prepend v-if="prepend">
				<span class="input-group-text">{{ prepend }}</span>
			</b-input-group-prepend>

			<b-form-input
				@keypress="isNumber($event)"
				v-model="fakeSalary"
				@focus="setHidden(true)"
				:hidden="isHidden"
				:state="_state"
				:value="fakeSalary"
				:disabled="disabled"
				:class="_class"
				:size="size"
				:data-vv-as="_dataVvAs"
				style="height: 35px;margin-top: 2px;"
				:placeholder="placeholder"
			/>
			<b-form-input
				@keypress="isNumber($event)"
				:id="_name"
				:name="_name"
				:ref="_name"
				v-model="inputVal"
				@blur="setHidden(false)"
				@change="(val) => $emit('change', val)"
				:hidden="!isHidden"
				:state="state"
				:value="value"
				type="search"
				min="0"
				step="0.01"
				autocomplete="off"
				:disabled="disabled"
				:class="_class"
				:size="size"
				:data-vv-as="_dataVvAs"
				style="height: 35px;margin-top: 2px;"
				:placeholder="placeholder"
			/>

			<!-- ส่วนท้ายถ้ามี prop -->
			<b-input-group-append v-if="append">
				<span class="input-group-text">{{ append }}</span>
			</b-input-group-append>

			<!-- ส่วนแสดงผล real time -->
			<!-- <b-tooltip :target="() => $refs[id]" show>{{
      getLocaleString(inputVal) || 'กรุณากรอกข้อมูล'
			}}</b-tooltip>-->

			<b-popover
				:target="_name"
				triggers="focus"
				placement="top"
				variant="danger"
				>{{ getLocaleString(inputVal) || _textPopup }}</b-popover
			>

			<!-- ส่วนการ validate -->

			<!-- <b-form-invalid-feedback id="input-live-feedback" v-if="_error">
        {{
        errors.items.find(f => f.field === name).msg
        }}
			</b-form-invalid-feedback>-->
		</b-input-group>

		<small
			id="input-live-feedback"
			class="form-text text-danger"
			v-if="_error"
			>{{ _dataVvAs }}</small
		>
	</div>
</template>
<script>
export default {
	props: {
		placeholder: {
			type: String,
			default: '',
		},
		dataVvAs: {
			type: String,
			default: '',
		},
		// id: String,
		name: {
			type: String,
			default:
				`name_` + Math.floor(Math.random() * (0 - 999999 + 999999999999)) + 1,
		},
		validate: String,
		value: null,
		state: null,
		decimal: Boolean,
		invalidFeedback: String,
		disabled: {
			type: Boolean,
			default: false,
		},
		size: {
			type: String,
			default: 'sm',
		},
		textClass: {
			type: String,
			default: 'right', // left|center|right
		},
		/**
		 * ต่อข้อความ หน้า หรือ หลังช่อ ที่จะกรอกข้อมูล
		 */
		prepend: { type: String, default: null },
		append: { type: String, default: null },

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
			type: Number,
			default: 9999999999999999,
		},
		decimalLength: { type: Number, default: 2 },
		/**
		 * =========================================================
		 */
	},
	computed: {
		_textPopup() {
			const dataVvAs = this.dataVvAs
			if (dataVvAs) {
				return `กรุณากรอก ข้อมูล${dataVvAs}`
			} else {
				return `'กรุณากรอกข้อมูล'`
			}
		},
		_dataVvAs() {
			return `กรุณากรอก ข้อมูล${this.dataVvAs}`
		},
		_name() {
			if (this.name) {
				return this.name
			} else {
				return (
					`name_` + Math.floor(Math.random() * (0 - 999999 + 999999999999)) + 1
				)
			}
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
		_class() {
			return `text-${this.textClass}`
		},
	},
	data() {
		return {
			// name:
			// 	`name_` + Math.floor(Math.random() * (0 - 999999 + 999999999999)) + 1,
			// id: this.genName,
			dirty: false,
			inputVal: this.value,
			isHidden: false,
			fakeSalary: this.getLocaleString(this.value),
		}
	},
	mounted() {},
	watch: {
		inputVal(val, old) {
			this.fakeSalary = this.getLocaleString(val)
			this.$emit('input', val)
			this.checkMax(old)
		},
		value(val) {
			this.dirty = true
			this.inputVal = val
			this.fakeSalary = this.getLocaleString(val)
			this.$emit('input', val)
		},
	},
	methods: {
		checkMax(newValue, oldValue) {
			if (this.checkMaximumInput) {
				if (newValue * 1 > this.maximumInput * 1) {
					// this.alertWarning(
					// 	`ค่าเกินกว่าที่กำหนด ไว้คือ ${this.withCommas(this.maximumInput)}`
					// )
					this.inputVal = this.maximumInput * 1
					return ''
				}
			}
		},
		isNumber: function(evt) {
			evt = evt ? evt : window.event
			var charCode = evt.which ? evt.which : evt.keyCode
			if (
				charCode > 31 &&
				(charCode < 48 || charCode > 57) &&
				charCode !== 46
			) {
				evt.preventDefault()
			} else {
				return true
			}
		},
		setHidden(bool) {
			if (this.value) {
				if (this.decimal) {
					this.$emit(
						'input',
						parseFloat(this.value).toFixed(this.decimalLength)
					)
				} else {
					this.$emit('input', parseFloat(this.value))
				}
			}
			this.isHidden = bool
			if (bool) this.$nextTick(() => this.$refs[this.name].focus())
		},
		getLocaleString(val, position) {
			if (val || val === 0) {
				const fixed = parseFloat(val).toFixed(
					position === undefined ? this.decimalLength : position
				)
				const temp = fixed.split('.')
				temp[0] = parseFloat(temp[0]).toLocaleString() || 0
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
