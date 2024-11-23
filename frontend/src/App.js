import Header from "./components/Header";
import Home from "./components/Home";
import EventDetail from "./components/EventDetail";
import AddEvent from "./components/AddEvent";
import { BrowserRouter, Route, Routes } from "react-router-dom";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Header />}>
          <Route index element={<Home />} />
          <Route path="event-details/:id" element={<EventDetail />} />
          <Route path="/add-event" element={<AddEvent />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
