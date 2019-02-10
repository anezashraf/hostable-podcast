import React from 'react'
import { Route, Link } from 'react-router-dom'
import Home from '../Pages/home'
import Settings from '../Pages/settings'
import Users from '../Pages/users'
import Episodes from '../Pages/episodes'
import Details from '../Pages/details'

const App = () => (
  <div>
    <header>
      <Link to="">Home</Link>
      <Link to="/dashboard/episodes">Episodes</Link>
      <Link to="/dashboard/details">Podcast Details</Link>
      <Link to="/dashboard/users">User Management</Link>
      <Link to="/dashboard/settings">Settings</Link>
    </header>

    <main>
      <Route exact path="/" component={Home} />
      <Route exact path="/dashboard/settings" component={Settings} />
      <Route exact path="/dashboard/users" component={Users} />
      <Route exact path="/dashboard/details" component={Details} />
      <Route exact path="/dashboard/episodes" component={Episodes} />
    </main>
  </div>
)

export default App
