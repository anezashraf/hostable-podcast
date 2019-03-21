import React from 'react'
import { Route, Link } from 'react-router-dom'
import Settings from '../Pages/settings'
import Details from '../Pages/details'
import User from '../Pages/user'
import Index from '../Pages/create-new-episode'

const App = () => (
  <div>
    <header>
      <Link to="">Home</Link>
      <Link to="/dashboard/details">Podcast Details</Link>
      <Link to="/dashboard/settings">Settings</Link>
      <Link to="/dashboard/user">User Management</Link>
    </header>

    <main>
      <Route exact path="/dashboard/settings" component={Settings} />
      <Route exact path="/dashboard/user" component={User} />
      <Route exact path="/dashboard/details" component={Details} />
      <Route exact path="/dashboard/create-episode" component={Index} />
    </main>
  </div>
)

export default App
