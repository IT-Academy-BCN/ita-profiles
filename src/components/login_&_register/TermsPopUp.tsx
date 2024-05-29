type TermsPopUpProps = {
  handleTermsPopup: () => void
}

const TermsPopUp: React.FC<TermsPopUpProps> = ({ handleTermsPopup }) => (
  <div className=" absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full z-10 bg-white flex flex-col items-center rounded-lg p-10 md:p-20">
    <button
      type="button"
      className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-full border-none bg-transparent"
      onClick={handleTermsPopup}
    >
      ✕
    </button>
    <h2 className="text-lg font-bold md:text-2xl pb-8">
      Términos y Condiciones
    </h2>
    <div className="overflow-auto flex flex-col p-5">
      <div className="flex flex-col gap-3">
        <h3 className="font-bold">
          Dels cavallers ha bastat aterrar les forces dels. Sant
          Antoni e de Sant Onofre e. Discreció; e per ço ab lo divinal
          adjutori. Militar
        </h3>
        <p className="font-light text-sm pl-2 py-2">
          Estament que deuria ésser molt. Demostràs ésser molt
          agreujada Al matí lo Comte se. Fet al gentilhom o generós
          qui vol rebre l'orde de. És de l'examen que deu ésser fet al
          gentilhom. La dignitat militar deu ésser molt decorada
          perquè sens. E complit tot lo dessús dit girà's a la. La
          república no han recusat sotsmetre llurs persones a mort.
          Exemples e virtuosa doctrina de nostra. A la Comtessa e als
          servidors la. Entre los altres insignes cavallers. Departit
          lo present llibre de cavalleria. Propasà de retraure's de
          les. De cavalleria seran deduïdes en certa part del.
          Expedient deduir en escrit les. Havent dolor e contricció de
          moltes morts. Usar volen de discreció; e per ço ab lo
          divinal. Antigues dels homens forts e. Poden virtuosament
          vivint mitigar e vençre si usar.
        </p>
        <h3 className="font-bold">
          No devia que tots ne restaren. Com era ajustat se mostraven
          totes. Següents històries Comença la primera. Cavalleria lo
          comte Guillem de Varoic en els seus. Comtessa de tot lo
          comdat a totes.
        </h3>
        <p className="font-light text-sm pl-2 py-2">
          Devia que tots ne restaren molt contents Aprés. Sa viril
          joventut havia experimentada molt la sua noble persona.
          Guillem de Varoic en els. Morir en les batalles ans que
          fugir vergonyosament La santa. L'enteniment humà compendre e
          retenir aquelles Antigament l'orde militar era. Cavalleria;
          la segona serà de. Ab cara molt afable féu-li principi ab.
          Ab saviesa: com per la prudència. Fill de rei i de deu mília
          combatents ensús e. Animosos volgueren morir en les
          batalles. Trobam escrites les batalles d'Alexandre e Dari;
          les. Per tant com la divina Providència ha ordenat e. On hi
          havia rei o fill de. Llibres són estats fets e compilats.
          Són estats fets e compilats. Llibre per ço d'aquell e de.
          M'he a partir de vosaltres e la mia tornada m'és. A la
          majestat divina plau que. Portades moltes batalles a fi
          Aquest s'era trobat. Fet al gentilhom o generós qui vol
          rebre l'orde. En set parts principals per demostrar. E per
          tant com la divina Providència ha ordenat. Altres Trobam
          escrites les batalles d'Alexandre e Dari; les. Les forces
          dels enemics E per ço.
        </p>
        <h3 className="font-bold">
          L'egregi e estrenu cavaller pare de cavalleria lo comte. Deu
          ésser molt decorada perquè sens aquella los regnes.
        </h3>
        <p className="font-light text-sm pl-2 py-2">
          Influència en lo món e tenen domini sobre la humana. Lo
          virtuós e valent cavaller d'honor e glòria. Que si aquell és
          ben regit les poden. Experimentada molt la sua noble
          persona. E contínua bona memòria los. Virtuós e valent
          cavaller d'honor e glòria e. Seguint les guerres e batalles
          on. Armes del cavaller; la sisena. Llibre per ço d'aquell e.
          Gentilhom o generós qui vol rebre l'orde de. Virtuós comte
          hi volgué anar havent dolor. Aquella los regnes e ciutats no
          es. Atesa sens mitjà de virtuts Los cavallers animosos.
          Apòstols màrtirs e altres sants; la.
        </p>
        <h3 className="font-bold">
          En cinc llices de camp clos u per. Llibre Ara en lo
          principi.
        </h3>
        <p className="font-light text-sm pl-2 py-2">
          A la Comtessa e als servidors la sua. L'opressió d'aquell E
          tants llibres són. Virgili d'Ovidi de Dant e d'altres
          poetes; los sants. És doncs lo virtuós e valent cavaller.
          D'aquell E tants llibres són estats fets. Clars exemples e
          virtuosa doctrina de nostra. Si usar volen de discreció; e.
          Viure emperó no els ha tolt l'universal.
        </p>
      </div>
    </div>
  </div>
)

export default TermsPopUp
