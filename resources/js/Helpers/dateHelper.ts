/**
 *
 * @param dateString string
 * @description Formata uma string de data para o formato brasileiro (dd/mm/yyyy hh:mm)
 * @returns string
 */
const formatDateToBr = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

export {
  formatDateToBr
}
