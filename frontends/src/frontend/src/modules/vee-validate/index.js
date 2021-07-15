import { Validator } from 'vee-validate'

const checkID = (id, length = 13) => {
  if (id.length != length) return false
  let sum = 0
  for (let i = 0; i < length - 1; i++)
    sum += parseFloat(id.charAt(i)) * (length - i)
  if ((11 - (sum % 11)) % 10 != parseFloat(id.charAt(length - 1))) return false
  return true
}

const checkDate = (value, format) => {
  // รูปแบบ format ที่เจอในระบบทั้งหมด
  // DD/MM/YYYY | dd/MM/yyyy | DD/MM/YYYY HH:mm
  // * แต่ moment ต้องใช้ DD/MM/YYYY เท่านั้น
  let tmp_format = format[0].split(' ')
  let tmp_value = value.split(' ')
  let tmp = tmp_value[0].split('/')
  let date = ''
  let current_year = moment().format('YYYY')

  // ตรวจว่าค่าปีที่เข้ามาควรจะลบ 543 ดีหรือไม่
  //   จากการกำหนดขอบเขต 150-คศ(ปัจจุบัน)+150
  //   ถ้าค่าที่ส่งมา อยู่ในช่วง แสดงว่า คือ คศ จะไม่ลบ
  //    แต่ถ้าไม่อยู่ในช่วง(Invert) แสดงว่าเป็น พศ จะลบ 543
  //1870  2170
  if (!(current_year - 150 <= tmp[2] && tmp[2] <= current_year + 150)) {
    tmp[2] = tmp[2] - 543
  }

  if (tmp_value.length == 2) {
    date = `${tmp[0]}/${tmp[1]}/${tmp[2]} ${tmp_value[1]}`
  } else {
    date = `${tmp[0]}/${tmp[1]}/${tmp[2]}`
  }
  // console.log(`vee-validate Fn checkDate ${date} ${format[0]}`)
  if (tmp_format.length == 2) {
    return moment(
      date,
      `${tmp_format[0].toUpperCase()} ${tmp_format[1]}`
    ).isValid()
  }
  return moment(date, 'DD/MM/YYYY').isValid()
}

/** กฏที่ใช้ตรวจอายุต้องมากกว่า ค่าที่ส่งเข้ามา */
const checkAgeMoreThan = (value, value_min = 20) => {
  // รูปแบบ format ที่เจอในระบบทั้งหมด
  // DD/MM/YYYY | dd/MM/yyyy | DD/MM/YYYY HH:mm
  // * แต่ moment ต้องใช้ DD/MM/YYYY เท่านั้น
  let tmp_value = value.split(' ')
  let tmp = tmp_value[0].split('/')
  let current_year = moment().format('YYYY')

  // ตรวจว่าค่าปีที่เข้ามาควรจะลบ 543 ดีหรือไม่
  //   จากการกำหนดขอบเขต 150-คศ(ปัจจุบัน)+150
  //   ถ้าค่าที่ส่งมา อยู่ในช่วง แสดงว่า คือ คศ จะไม่ลบ
  //    แต่ถ้าไม่อยู่ในช่วง(Invert) แสดงว่าเป็น พศ จะลบ 543
  //1870  2170
  if (!(current_year - 150 <= tmp[2] && tmp[2] <= current_year + 150)) {
    tmp[2] = tmp[2] - 543
  }
  let date = `${tmp[2]}-${tmp[1]}-${tmp[0]}`
  let years = moment().diff(`${date}`, 'years')

  console.log(`vee-validate Fn checkAgeMoreThan ${years} ${value_min}`)

  return years >= value_min
}
const isUniqueInventoryProgramCode = (value, type) => {

  if (type.length) {
    console.log(type)
    if (type[1]) {
      // มีค่า ID ส่งมาด้วยแสดงว่าเป็นการแก้ไขไม่ต้องตรวจ
      return {
        valid: true,
        data: {
          message: 'สามารถใช้ได้'
        }
      }
    }
    if (type[0] == 'code') {
      return axios
        .post('/api/helper/checkCodeInventoryProgram', { code: value })
        .then(response => {
          return {
            valid: response.data.valid,
            data: {
              message: response.data.message
            }
          }
        })
    }
  }
  return {
    valid: true,
    data: {
      message: 'สามารถใช้ได้'
    }
  }
}

const isUnique = (value, type) => {
  if (type.length) {
    if (type[1]) {
      // มีค่า ID ส่งมาด้วยแสดงว่าเป็นการแก้ไขไม่ต้องตรวจ
      return {
        valid: true,
        data: {
          message: 'สามารถใช้ได้'
        }
      }
    }
    if (type[0] == 'code') {
      return axios
        .post('/api/helper/checkCode', { code: value })
        .then(response => {
          return {
            valid: response.data.valid,
            data: {
              message: response.data.message
            }
          }
        })
    } else if (type[0] == 'code_gen') {
      return axios
        .post('/api/helper/checkCodeGen', { code_gen: value })
        .then(response => {
          return {
            valid: response.data.valid,
            data: {
              message: response.data.message
            }
          }
        })
    }
  }
  return {
    valid: true,
    data: {
      message: 'สามารถใช้ได้'
    }
  }
}

Validator.extend('checkId', {
  getMessage: (field, [len]) =>
    field + ' ' + (len ? len + ' หลัก' : '') + ' ไม่ถูกต้อง',
  validate: (value, [len]) => checkID(value, len)
})

Validator.extend('date_format', {
  getMessage: (field, format) => `${field} ไม่ถูกต้อง ตามรูปแบบ ${format}`,
  validate: (value, format) => checkDate(value, format)
})

Validator.extend('check_age_more_than', {
  getMessage: (field, value_min) => `${field} ต้องมากกว่า ${value_min} ปี`,
  validate: (value, value_min) => checkAgeMoreThan(value, value_min)
})

/** ตรวจการไม่ซ้ำกันของข้อมูล */
// ต้องส่ง param type มี 2 ค่า ว่าต้องการตรวจไม่ซ้ำเรื่องอะไรมาด้วย
// * Type ตัวที่ 1 ที่ใช้ได้  code_gen
// * Type ตัวที่ 2 ID ข้อมูลนั้นๆ ถ้ามีจะคิดว่าเป็นการแก้(ไม่ต้องส่งตรวจ) ถ้าไม่มีคือเพิ่มใหม่(ตรวจจริงๆ)
Validator.extend('unique', {
  validate: isUnique,
  getMessage: (field, params, data) => {
    return data.message
  }
})
Validator.extend('uniqueInventoryProgramCode', {
  validate: isUniqueInventoryProgramCode,
  getMessage: (field, params, data) => {
    return data.message
  }
})
