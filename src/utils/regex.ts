// File for regular expressions
const REGEX_USERNAME = /^(?!\s)(?!.*\s$)[a-zA-Z0-9\s]{3,}$/;
const REGEX_DNI_NIF_NIE = /^[XYZ]{0,1}[0-9]{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/
const REGEX_DNI = /^(\d{8})([A-Z])$/;
const REGEX_NIE = /^[KLMXYZ][0-9]{7}[A-Z]$/i;
const REGEX_EMAIL = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const REGEX_SPECIALIZATION = /^(Frontend|Backend|Fullstack|Data Science|Not Set)$/;
const REGEX_PASWWORD = /^(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/;
const REGEX_PASWWORD_CONFIRMATION = REGEX_PASWWORD;
const REGEX_TERMS = /^(false|true)$/;

export {
  REGEX_USERNAME,
  REGEX_DNI,
  REGEX_NIE,
  REGEX_DNI_NIF_NIE,
  REGEX_EMAIL,
  REGEX_SPECIALIZATION,
  REGEX_PASWWORD,
  REGEX_PASWWORD_CONFIRMATION,
  REGEX_TERMS
}