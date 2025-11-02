export function newStudent() {
  return {
    std_id: '',
    email: '',
    password: '',
    name: '',
    birth: '',
    gender: 'M',
    admission_year: new Date().getFullYear(),
    current_year: 1,
    status: '재학',
  }
}
