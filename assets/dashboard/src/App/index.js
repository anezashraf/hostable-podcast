import React from 'react'
import { Route, Link } from 'react-router-dom'
import Settings from '../Pages/settings'
import Details from '../Pages/details'

const App = () => (
  <div>
    <header>
      <Link to="">Home</Link>
      <Link to="/dashboard/details">Podcast Details</Link>
      <Link to="/dashboard/settings">Settings</Link>
    </header>

    <main>
      <Route exact path="/dashboard/settings" component={Settings} />
      <Route exact path="/dashboard/details" component={Details} />
    </main>
  </div>
)

export default App
