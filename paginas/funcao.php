import { useState } from "react";

function AddonButton({ addon, selected, onToggle }) {
  return (
    <button
      type="button"
      onClick={() => onToggle(addon.id)}
      className={selected ? "border-accent" : "border-border"}
    >
      {addon.name}
    </button>
  );
}

export default function App() {
  const [enviado, setEnviado] = useState(false);
  const [addons, setAddons] = useState([]);

  const handleSubmit = (e) => {
    e.preventDefault();
    setEnviado(true);
  };

  const toggleAddon = (id) => {
    setAddons((prev) =>
      prev.includes(id) ? prev.filter((x) => x !== id) : [...prev, id]
    );
  };

  return (
    <div>
      <button onClick={() => console.log("cliquei!")}>Clique</button>
      <button onClick={() => window.open("https://wa.me/5511999999999", "_blank")}>
        Falar no WhatsApp
      </button>

      {enviado ? (
        <p>Agendamento confirmado!</p>
      ) : (
        <form onSubmit={handleSubmit}>
          {/* campos do formulário */}
          <button type="submit">Enviar</button>
        </form>
      )}

      {/* exemplo de addons */}
      {[
        { id: "1", name: "Extra café" },
        { id: "2", name: "Sobremesa" },
      ].map((a) => (
        <AddonButton
          key={a.id}
          addon={a}
          selected={addons.includes(a.id)}
          onToggle={toggleAddon}
        />
      ))}
    </div>
  );
}

