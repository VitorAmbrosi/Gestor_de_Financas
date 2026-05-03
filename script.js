function calcularSaldo() {
  const container = document.getElementById('saldoFinal')
  if (!container) return

  const linhas = document.querySelectorAll('tbody tr')
  let saldo = 0

  linhas.forEach((linha) => {
    const colunas = linha.querySelectorAll('td')
    if (colunas.length < 4) return

    const valorTexto = colunas[1].textContent.trim()
    const tipo = colunas[3].textContent.trim().toLowerCase()

    const valorLimpo = valorTexto
      .replace(/[^\d,]/g, '')
      .replace(',', '.')

    const valor = parseFloat(valorLimpo)
    if (isNaN(valor)) return

    if (tipo.includes('entrada')) {
      saldo += valor
    } else if (tipo.includes('sa')) {
      saldo -= valor
    }
  })

  const positivo = saldo >= 0
  const valorFormatado = Math.abs(saldo).toLocaleString('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  })

  container.innerHTML = `
    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Saldo atual:</span>
    <span class="text-lg font-bold ${positivo ? 'text-green-600' : 'text-red-600'}">
      ${positivo ? '' : '- '}R$ ${valorFormatado}
    </span>
  `
}

function validarFormulario(form) {
  const campos = form.querySelectorAll('input[required], select[required], textarea[required]')
  let valido = true

  campos.forEach((campo) => {
    limparErro(campo)

    const vazio =
      campo.value.trim() === '' ||
      (campo.tagName === 'SELECT' && campo.value === '')

    if (vazio) {
      marcarErro(campo)
      valido = false
    }
  })

  return valido
}

function marcarErro(campo) {
  campo.classList.add(
    'border-red-500',
    'bg-red-50',
    'focus:ring-red-300',
    'outline-none',
    'ring-2',
    'ring-red-300'
  )
  campo.classList.remove('border-slate-300')

  const msg = document.createElement('p')
  msg.className = 'text-red-500 text-xs mt-1 campo-erro'
  msg.textContent = 'Este campo é obrigatório.'
  campo.insertAdjacentElement('afterend', msg)
}

function limparErro(campo) {
  campo.classList.remove(
    'border-red-500',
    'bg-red-50',
    'focus:ring-red-300',
    'ring-2',
    'ring-red-300'
  )
  campo.classList.add('border-slate-300')

  const msgAnterior = campo.nextElementSibling
  if (msgAnterior && msgAnterior.classList.contains('campo-erro')) {
    msgAnterior.remove()
  }
}

document.addEventListener('DOMContentLoaded', () => {

  calcularSaldo()

  document.querySelectorAll('form').forEach((form) => {

    form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"]')
      .forEach((campo) => campo.setAttribute('required', ''))

    form.querySelectorAll('select').forEach((campo) => campo.setAttribute('required', ''))

    form.addEventListener('input', (e) => limparErro(e.target), true)
    form.addEventListener('change', (e) => limparErro(e.target), true)

    form.addEventListener('submit', (e) => {
      if (!validarFormulario(form)) {
        e.preventDefault()

        const primeiroErro = form.querySelector('.border-red-500')
        if (primeiroErro) primeiroErro.focus()
      }
    })
  })

})