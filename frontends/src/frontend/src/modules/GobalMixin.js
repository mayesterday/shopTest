import Vue from 'vue'
import moment from 'moment'
const vsprintf = require('sprintf-js').vsprintf

Vue.mixin({
	methods: {
		beforeDateSendDB(date) {
			const b = date.split('/')
			b[2] -= 543
			return `${b[0]}/${b[1]}/${b[2]}`
		},
		/**
     * แยกข้อมูลออกจาก master data
     * @note เอาไว้แยกข้อมูลออกมาจากข้อมูลหลัก เวลาแก้แล้วจะไม่ไปกระทบกับตับ master data
     * @param {Object} src
     */
		coppyParam(src) {
			return JSON.parse(JSON.stringify(src))
		},
		cp(src) {
			return JSON.parse(JSON.stringify(src))
		},
		/**
     * =========================
     */

		sprint(master, text) {
			return vsprintf(master, [text + ''])
		},
		/**
     * แปลง วันที่ ที่ดึงมาจากฐานข้อมูลให้อยู่ในรูปแบบ วัน เดือน ปี
     * @param {date} date วัน/เดือน/ปี Example: 01/02/2563
     * @return  ปี/เดือน/วัน Example: 2020-02-01
     */
		convertDateDB(date) {
			return moment(date.convertDate(), 'DD/MM/YYYY').format('YYYY-MM-DD')
		},
		/**
     * แปลง คศ เป็น พ.ศ
     * @param {date} date
     * @param {Object}
     *  fulldate true แสดง วัน เดือน ปี เต็ม / false แบบตัวเลข
     *  abb แสดงเดือนเป็นแบบตัวย่อ
     */
		convertDateToThai(date, options = { fulldate: false, abb: false }) {
			if (!date) return ''

			let { fulldate, abb } = options
			let convertDate = moment(date).format('DD/MM/YYYY')
			// .convertDate()
			if (fulldate) {
				return this.DateThai(convertDate, abb)
			}
			return convertDate
		},
		DateThai(strDate, abb) {
			let splitDate = strDate.split('/')
			var monthNamesThai = [
				'มกราคม',
				'กุมภาพันธ์',
				'มีนาคม',
				'เมษายน',
				'พฤษภาคม',
				'มิถุนายน',
				'กรกฎาคม',
				'สิงหาคม',
				'กันยายน',
				'ตุลาคม',
				'พฤษจิกายน',
				'ธันวาคม',
			]
			var monthNamesThaiAbb = [
				'ม.ค.',
				'ก.พ.',
				'มี.ค.',
				'เม.ย.',
				'พ.ค.',
				'มิ.ย.',
				'ก.ค.',
				'ส.ค.',
				'ก.ย.',
				'ต.ค.',
				'พ.ย.',
				'ธ.ค.',
			]

			var dayNames = [
				'วันอาทิตย์ที่',
				'วันจันทร์ที่',
				'วันอังคารที่',
				'วันพุทธที่',
				'วันพฤหัสบดีที่',
				'วันศุกร์ที่',
				'วันเสาร์ที่',
			]

			if (abb) {
				return `${splitDate[0]} ${monthNamesThaiAbb[
					splitDate[1] - 1
				]} ${splitDate[2] * 1 + 543}`
			} else {
				return `${splitDate[0]} ${monthNamesThai[
					splitDate[1] - 1
				]} ${splitDate[2] * 1 + 543}`
			}
		},
		withCommas(number, decimal = true) {
			let _return = 0
			if (number) {
				let temp
				if (decimal) {
					temp = parseFloat(number, 10).toFixed(2).split('.')
					_return = `${parseFloat(temp[0], 10).toLocaleString()}.${temp[1]}`
				} else {
					temp = parseFloat(number, 10)
					_return = `${parseFloat(temp, 10).toLocaleString()}`
				}

				// _return = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
			} else {
				_return = number
			}

			if (_return) {
				return _return
			}
			return 0
		},
		withoutCommas(number) {
			number.replace(',', '')
		},
		objectToFormData(data) {
			const payload = new FormData()
			/**
       * วนลูปเอา key ของ object มากำหนด
       * เป็น index สำหรับส่งไป server
       */
			for (let i in data) {
				// เช็คว่าเป็น Array หรือไม่
				if (data[i] instanceof Array) {
					arrayToForm(payload, data[i], i)
				} else if (data[i] instanceof File) {
					payload.append(i, data[i], data[i].name)
				} else if (typeof data[i] === 'object') {
					// เผื่อกรณีมี object ซ้อน object
					for (let j in data[i]) {
						appendType(payload, data[i][j], `${i}[${j}]`)
					}
				} else {
					appendType(payload, data[i], i)
				}
			}
			return payload
		},
		replacer(key, value) {
			// Filtering out properties
			if (value === null) {
				return undefined
			}
			return value
		},
		replaceDate(data) {
			if (!data) {
				return data
			}
			if (data instanceof Array) {
				data.map(item => {
					if (typeof item === 'object') {
						this.replaceDate(item)
					} else {
						item = checkConvert(item)
					}
				})
			} else {
				Object.keys(data).map(key => {
					if (typeof data[key] === 'object') {
						this.replaceDate(data[key])
					} else {
						data[key] = checkConvert(data[key])
					}
				})
			}
			return data
		},
		convertDate(data) {
			return checkConvert(data)
		},
		urltoFile(url, filename, mimeType) {
			return fetch(url)
				.then(function(res) {
					return res.arrayBuffer()
				})
				.then(function(buf) {
					return new File([buf], filename, { type: mimeType })
				})
		},
	},
})

const arrayToForm = (payload, data, formKey) => {
	if (data instanceof Array) {
		// ลูปเอาค่าใน array ไปใช้
		data.map((item, key) => {
			doObject(payload, item, `${formKey}[${key}]`)
		})
	} else {
		for (let i in data) {
			doObject(payload, data[i], `${formKey}[${i}]`)
		}
	}
}

const doObject = (payload, data, key) => {
	/**
   * แก้ไขกรณีเป็นไฟล์ ที่เป็น array ซ้อนอยู่ใน object
   * แล้ว typeof มันเป็น object เหมือนกัน ทำให้มัน
   * ไปลูปใส่ object อีกรอบ เลยไม่ได้ส่งเป็น binary
   */
	if (data instanceof File) {
		payload.append(key, data, data.name)
	} else if (typeof data === 'object') {
		// ถ้าใน array มี object อีก ต้องเอา key ไปใช้
		/**
     * ถ้ายังเป็นแบบ object ซ้อนเข้าไปอีก ก็ให้ทำการเรียกตัวเอง
     * โดย key จะถูกต่อเข้าไปเรื่อยๆ
     * เป็น แบบ column[0][1] จะต่อ [key] ไปจนกว่าจะหมด
     */
		arrayToForm(payload, data, key)
	} else {
		/**
     * ถ้าเข้าในส่วนนี้แปลว่า ไม่มี object ซ้อนเข้าไปอีก ให้ทำการ append ไปใน
     * FormData ได้เลย appendType เป็นการเช็คว่าเป็น image หรือไม่
     */
		appendType(payload, data, key)
	}
}

const appendType = (payload, data, key) => {
	if (data instanceof File) {
		payload.append(key, data, data.name)
	} else {
		if (typeof data !== 'undefined') {
			payload.append(key, checkConvert(data))
		}
	}
}

const checkConvert = data => {
	// console.log(data)
	return typeof data === 'string'
		? data.toCE().toString()
		: data instanceof String ? data.toString() : data
}
