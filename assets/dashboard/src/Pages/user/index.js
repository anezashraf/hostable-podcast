import React from 'react'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'
import { fetchUsers, fetchInvitationLink, updateUser } from '../../modules/users'
import UserForm from '../../Components/Forms/UserForm'
import PropTypes from 'prop-types';


class User extends React.Component {
  constructor (props) {
    super(props)

    this.state = {
      invitationLink: ''
    }
  }

  componentDidMount () {
    this.props.fetchUsers()
  }

    handleUpdate = (id, value) => {
      this.props.updateUser(id, value)
    };

    handleCreateLink = () => {
      this.props.fetchInvitationLink()
    };

    render () {
      let { users } = this.props

      return (
        <section>
          {users.map((value, index) => {
            return (<UserForm handleUpdate={this.handleUpdate} key={index} user={value} />)
          })}

          <button onClick={this.handleCreateLink}>Get Invitation Link</button>
          <p>{this.props.invitationLink}</p>

        </section>
      )
    }
}


User.propTypes = {
  fetchUsers: PropTypes.func,
  updateUser: PropTypes.func,
  fetchInvitationLink: PropTypes.func,
  users: PropTypes.array,
  user: PropTypes.object,
  invitationLink: PropTypes.string,
};

const mapStateToProps = ({ user }) => ({
  users: user.users,
  invitationLink: user.invitationLink

})

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchUsers,
      updateUser,
      fetchInvitationLink
    },
    dispatch
  )

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(User)
